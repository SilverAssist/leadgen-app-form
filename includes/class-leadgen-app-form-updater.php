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
 * @version 1.0.2
 */

namespace LeadGenAppForm;

// Prevent direct access
if (!defined("ABSPATH")) {
  exit;
}

class LeadGen_App_Form_Updater
{

  /**
   * Plugin file path
   * @var string
   */
  private string $plugin_file;

  /**
   * Plugin slug (folder/file.php)
   * @var string
   */
  private string $plugin_slug;

  /**
   * Plugin basename (folder name only)
   * @var string
   */
  private string $plugin_basename;

  /**
   * GitHub repository (owner/repo)
   * @var string
   */
  private string $github_repo;

  /**
   * Current plugin version
   * @var string
   */
  private string $current_version;

  /**
   * Plugin data from header
   * @var array
   */
  private array $plugin_data;

  /**
   * Transient name for version cache
   * @var string
   */
  private string $version_transient;

  /**
   * Initialize the updater
   *
   * @param string $plugin_file Full path to main plugin file
   * @param string $github_repo GitHub repository in format "owner/repo"
   */
  public function __construct(string $plugin_file, string $github_repo)
  {
    $this->plugin_file = $plugin_file;
    $this->plugin_slug = plugin_basename($plugin_file);
    $this->plugin_basename = dirname($this->plugin_slug);
    $this->github_repo = $github_repo;
    $this->version_transient = "{$this->plugin_basename}_version_check";

    // Get plugin data
    if (!function_exists("get_plugin_data")) {
      require_once ABSPATH . "wp-admin/includes/plugin.php";
    }
    $this->plugin_data = \get_plugin_data($plugin_file);
    $this->current_version = $this->plugin_data["Version"];

    $this->init_hooks();
  }

  /**
   * Initialize WordPress hooks
   */
  private function init_hooks(): void
  {
    \add_filter("pre_set_site_transient_update_plugins", [$this, "check_for_update"]);
    \add_filter("plugins_api", [$this, "plugin_info"], 20, 3);
    \add_action("upgrader_process_complete", [$this, "clear_version_cache"], 10, 2);

    // Add custom action for manual version check
    \add_action("wp_ajax_leadgen_check_version", [$this, "manual_version_check"]);
  }

  /**
   * Check for plugin updates
   *
   * @param mixed $transient WordPress update transient
   * @return mixed Modified transient
   */
  public function check_for_update($transient)
  {
    if (empty($transient->checked)) {
      return $transient;
    }

    $remote_version = $this->get_remote_version();

    if ($remote_version && \version_compare($this->current_version, $remote_version, "<")) {
      $transient->response[$this->plugin_slug] = (object) [
        "slug" => $this->plugin_basename,
        "plugin" => $this->plugin_slug,
        "new_version" => $remote_version,
        "tested" => "6.7",
        "requires_php" => "8.0",
        "url" => "https://github.com/{$this->github_repo}",
        "package" => $this->get_download_url($remote_version),
        "icons" => [
          "1x" => "",
          "2x" => ""
        ],
        "banners" => [
          "1x" => "",
          "2x" => ""
        ],
        "banners_rtl" => [],
        "compatibility" => []
      ];
    }

    return $transient;
  }

  /**
   * Provide plugin information for update screen
   *
   * @param mixed $response Default response
   * @param string $action API action
   * @param object $args API arguments
   * @return mixed Plugin info response
   */
  public function plugin_info($response, string $action, object $args)
  {
    if ($action !== "plugin_information" || $args->slug !== $this->plugin_basename) {
      return $response;
    }

    $remote_version = $this->get_remote_version();
    $release_info = $this->get_release_info($remote_version);

    return (object) [
      "name" => $this->plugin_data["Name"],
      "slug" => $this->plugin_basename,
      "plugin" => $this->plugin_slug,
      "version" => $remote_version ?: $this->current_version,
      "author" => $this->plugin_data["Author"],
      "author_profile" => $this->plugin_data["AuthorURI"],
      "requires" => "5.0",
      "tested" => "6.7",
      "requires_php" => "8.0",
      "sections" => [
        "description" => $this->plugin_data["Description"],
        "changelog" => $release_info["changelog"] ?? "See GitHub releases for changes.",
        "installation" => "Upload the plugin ZIP file through WordPress admin or extract to wp-content/plugins/."
      ],
      "download_link" => $this->get_download_url($remote_version),
      "homepage" => "https://github.com/{$this->github_repo}",
      "last_updated" => $release_info["published_at"] ?? date("Y-m-d"),
      "num_ratings" => 0,
      "rating" => 0
    ];
  }

  /**
   * Get latest version from GitHub releases
   *
   * @return string|false Remote version or false on failure
   */
  private function get_remote_version()
  {
    // Check cache first
    $cached_version = \get_transient($this->version_transient);
    if ($cached_version !== false) {
      return $cached_version;
    }

    $api_url = "https://api.github.com/repos/{$this->github_repo}/releases/latest";

    // Standard headers for GitHub API (public repository)
    $headers = [
      "Accept" => "application/vnd.github.v3+json",
      "User-Agent" => "LeadGen-App-Form-Updater/1.0"
    ];

    $response = \wp_remote_get($api_url, [
      "timeout" => 15,
      "headers" => $headers
    ]);

    if (\is_wp_error($response)) {
      return false;
    }

    $response_code = \wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
      return false;
    }

    $release = json_decode(\wp_remote_retrieve_body($response), true);
    if (!$release || !isset($release["tag_name"])) {
      return false;
    }

    $version = str_replace("v", "", $release["tag_name"]);

    // Cache for 12 hours
    \set_transient($this->version_transient, $version, 12 * HOUR_IN_SECONDS);

    return $version;
  }

  /**
   * Get release information for a specific version
   *
   * @param string $version Version to get info for
   * @return array Release information
   */
  private function get_release_info(string $version): array
  {
    $api_url = "https://api.github.com/repos/{$this->github_repo}/releases/tags/v{$version}";

    // Standard headers for GitHub API (public repository)
    $headers = [
      "Accept" => "application/vnd.github.v3+json",
      "User-Agent" => "LeadGen-App-Form-Updater/1.0"
    ];

    $response = \wp_remote_get($api_url, [
      "timeout" => 15,
      "headers" => $headers
    ]);

    if (\is_wp_error($response) || \wp_remote_retrieve_response_code($response) !== 200) {
      return [];
    }

    $release = json_decode(\wp_remote_retrieve_body($response), true);

    return [
      "changelog" => $release["body"] ?? "",
      "published_at" => isset($release["published_at"]) ? date("Y-m-d", strtotime($release["published_at"])) : ""
    ];
  }

  /**
   * Get download URL for a specific version
   *
   * @param string $version Version to download
   * @return string Download URL
   */
  private function get_download_url(string $version): string
  {
    return "https://github.com/{$this->github_repo}/releases/download/v{$version}/leadgen-app-form-v{$version}.zip";
  }

  /**
   * Clear version cache after plugin update
   *
   * @param object $upgrader WordPress upgrader instance
   * @param array $hook_extra Extra hook data
   */
  public function clear_version_cache($upgrader, array $hook_extra): void
  {
    if (isset($hook_extra["plugin"]) && $hook_extra["plugin"] === $this->plugin_slug) {
      \delete_transient($this->version_transient);
    }
  }

  /**
   * Manual version check via AJAX
   */
  public function manual_version_check(): void
  {
    if (!\current_user_can("update_plugins")) {
      \wp_die(\__("Insufficient permissions.", "leadgen-app-form"));
    }

    \check_ajax_referer("leadgen_version_check", "nonce");

    // Clear cache and check for new version
    \delete_transient($this->version_transient);
    $remote_version = $this->get_remote_version();

    if ($remote_version && \version_compare($this->current_version, $remote_version, "<")) {
      \wp_send_json_success([
        "has_update" => true,
        "current_version" => $this->current_version,
        "new_version" => $remote_version,
        "message" => sprintf(
          \__("New version %s is available! Current version: %s", "leadgen-app-form"),
          $remote_version,
          $this->current_version
        )
      ]);
    } else {
      \wp_send_json_success([
        "has_update" => false,
        "current_version" => $this->current_version,
        "message" => \__("You have the latest version installed.", "leadgen-app-form")
      ]);
    }
  }

  /**
   * Get current plugin version
   *
   * @return string Current version
   */
  public function get_current_version(): string
  {
    return $this->current_version;
  }

  /**
   * Get GitHub repository
   *
   * @return string Repository name
   */
  public function get_github_repo(): string
  {
    return $this->github_repo;
  }
}
