<?php

/**
 * LeadGen App Form Updater - Custom GitHub Updates Handler
 *
 * Handles automatic updates from public GitHub releases for the LeadGen App Form Plugin.
 * Provides seamless WordPress admin updates without requiring authentication tokens.
 *
 * @package LeadGenAppForm
 * @since 1.0.1
 * @author Silver Assist
 * @version 1.0.5
 */

namespace LeadGenAppForm;

// Prevent direct access
if (!defined("ABSPATH")) {
    exit;
}

class LeadGenAppFormUpdater
{
  /**
   * Plugin file path
   * @var string
   */
    private string $plugin_file;

  /**
   * GitHub repository (format: username/repository)
   * @var string
   */
    private string $github_repo;

  /**
   * Plugin slug (extracted from plugin file)
   * @var string
   */
    private string $plugin_slug;

  /**
   * Plugin basename (for WordPress hooks)
   * @var string
   */
    private string $plugin_basename;

  /**
   * Initialize the updater
   *
   * @param string $plugin_file   Path to main plugin file
   * @param string $github_repo   GitHub repository (username/repository)
   */
    public function __construct(string $plugin_file, string $github_repo)
    {
        $this->plugin_file = $plugin_file;
        $this->github_repo = $github_repo;
        $this->plugin_slug = dirname(plugin_basename($plugin_file));
        $this->plugin_basename = plugin_basename($plugin_file);

        $this->init_hooks();
    }

  /**
   * Initialize WordPress hooks
   */
    private function init_hooks(): void
    {
        \add_filter("pre_set_site_transient_update_plugins", [$this, "check_for_update"]);
        \add_filter("plugins_api", [$this, "plugin_info"], 10, 3);
        \add_filter("upgrader_pre_download", [$this, "download_package"], 10, 3);
        \add_action("wp_ajax_leadgen_check_version", [$this, "ajax_check_version"]);
    }

  /**
   * Check for plugin updates
   *
   * @param mixed $transient Update plugins transient
   * @return mixed Modified transient
   */
    public function check_for_update($transient)
    {
        if (empty($transient->checked)) {
            return $transient;
        }

        $remote_version = $this->get_remote_version();

        if (!$remote_version) {
            return $transient;
        }

        $current_version = $this->get_current_version();

        if (version_compare($current_version, $remote_version, "<")) {
            $transient->response[$this->plugin_basename] = (object) [
            "slug" => $this->plugin_slug,
            "new_version" => $remote_version,
            "url" => "https://github.com/{$this->github_repo}",
            "package" => "https://github.com/{$this->github_repo}/releases/download/v{$remote_version}/leadgen-app-form-v{$remote_version}.zip"
            ];
        }

        return $transient;
    }

  /**
   * Provide plugin information for update screen
   *
   * @param mixed  $result Plugin API result
   * @param string $action API action
   * @param object $args   API arguments
   * @return mixed Plugin info or original result
   */
    public function plugin_info($result, string $action, object $args)
    {
        if ($action !== "plugin_information") {
            return $result;
        }

        if ($args->slug !== $this->plugin_slug) {
            return $result;
        }

        $remote_version = $this->get_remote_version();

        if (!$remote_version) {
            return $result;
        }

        return (object) [
        "name" => "LeadGen App Form Plugin",
        "slug" => $this->plugin_slug,
        "version" => $remote_version,
        "author" => "Silver Assist",
        "homepage" => "https://github.com/{$this->github_repo}",
        "download_link" => "https://github.com/{$this->github_repo}/releases/download/v{$remote_version}/leadgen-app-form-v{$remote_version}.zip",
        "sections" => [
        "description" => "WordPress plugin that adds a shortcode to display LeadGen App forms with desktop-id and mobile-id parameters.",
        "changelog" => "See GitHub releases for changelog information."
        ]
        ];
    }

  /**
   * Download package from GitHub
   *
   * @param mixed  $reply    Download reply
   * @param string $package  Package URL
   * @param object $upgrader Upgrader instance
   * @return mixed Download result or original reply
   */
    public function download_package($reply, string $package, object $upgrader)
    {
        if (strpos($package, "github.com/{$this->github_repo}") === false) {
            return $reply;
        }

        return $package;
    }

  /**
   * Get remote version from GitHub API
   *
   * @return string|false Remote version or false on failure
   */
    private function get_remote_version()
    {
        $cache_key = "{$this->plugin_basename}_version_check";
        $cached_version = \get_transient($cache_key);

        if ($cached_version !== false) {
            return $cached_version;
        }

        $api_url = "https://api.github.com/repos/{$this->github_repo}/releases/latest";

        $response = \wp_remote_get($api_url, [
        "timeout" => 10,
        "headers" => [
        "User-Agent" => "WordPress/{$this->plugin_slug}"
        ]
        ]);

        if (\is_wp_error($response)) {
            return false;
        }

        $body = \wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (!isset($data["tag_name"])) {
            return false;
        }

        $version = ltrim($data["tag_name"], "v");

      // Cache for 12 hours
        \set_transient($cache_key, $version, 12 * HOUR_IN_SECONDS);

        return $version;
    }

  /**
   * Get current plugin version
   *
   * @return string Current version
   */
    public function get_current_version(): string
    {
        if (!function_exists("get_plugin_data")) {
            require_once ABSPATH . "wp-admin/includes/plugin.php";
        }

        $plugin_data = \get_plugin_data($this->plugin_file);
        return $plugin_data["Version"];
    }

  /**
   * Get GitHub repository
   *
   * @return string GitHub repository
   */
    public function get_github_repo(): string
    {
        return $this->github_repo;
    }

  /**
   * AJAX handler for manual version check
   */
    public function ajax_check_version(): void
    {
        if (!\check_ajax_referer("leadgen_version_check", "nonce", false)) {
            \wp_die("Security check failed");
        }

        if (!\current_user_can("manage_options")) {
            \wp_die("Insufficient permissions");
        }

      // Clear cache to force fresh check
        $cache_key = "{$this->plugin_basename}_version_check";
        \delete_transient($cache_key);

        $remote_version = $this->get_remote_version();
        $current_version = $this->get_current_version();

        if (!$remote_version) {
            \wp_send_json_error([
            "message" => \__("Could not check for updates. Please try again later.", "leadgen-app-form")
            ]);
        }

        $response = [
        "current_version" => $current_version,
        "remote_version" => $remote_version,
        "update_available" => version_compare($current_version, $remote_version, "<")
        ];

        if ($response["update_available"]) {
            $response["message"] = sprintf(
                \__("New version %s is available! Current version: %s", "leadgen-app-form"),
                $remote_version,
                $current_version
            );
        } else {
            $response["message"] = \__("Plugin is up to date!", "leadgen-app-form");
        }

        \wp_send_json_success($response);
    }

  /**
   * Force clear version cache
   */
    public function clear_version_cache(): void
    {
        $cache_key = "{$this->plugin_basename}_version_check";
        \delete_transient($cache_key);
    }
}
