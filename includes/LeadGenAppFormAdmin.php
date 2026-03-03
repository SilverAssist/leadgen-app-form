<?php

/**
 * LeadGen App Form Admin Page - Plugin Settings and Update Status
 *
 * Provides admin interface for plugin settings and update status display.
 * Integrates with SilverAssist Settings Hub for centralized admin interface.
 *
 * @package LeadGenAppForm
 * @since 1.0.1
 * @author Silver Assist
 * @version 1.2.0
 */

namespace LeadGenAppForm;

use SilverAssist\SettingsHub\SettingsHub;

// Prevent direct access
if (!defined("ABSPATH")) {
    exit;
}

class LeadGenAppFormAdmin
{
  /**
   * Plugin updater instance
   * @var LeadGenAppFormUpdater
   */
    private LeadGenAppFormUpdater $updater;

  /**
   * Initialize admin functionality
   *
   * @param LeadGenAppFormUpdater $updater Updater instance
   */
    public function __construct(LeadGenAppFormUpdater $updater)
    {
        $this->updater = $updater;
        $this->init_hooks();
    }

  /**
   * Initialize WordPress hooks
   */
    private function init_hooks(): void
    {
        \add_action("admin_menu", [$this, "register_with_hub"], 4);
        \add_action("admin_enqueue_scripts", [$this, "enqueue_admin_scripts"]);
    }

  /**
   * Register plugin with Settings Hub
   *
   * @return void
   */
    public function register_with_hub(): void
    {
        if (!\class_exists(SettingsHub::class)) {
            $this->add_standalone_menu();
            return;
        }

        try {
            $hub = SettingsHub::get_instance();

            $actions = [];
            $actions[] = [
                "label" => \__("Check Updates", "leadgen-app-form"),
                "callback" => [$this, "render_update_check_script"],
                "class" => "button",
            ];

            $hub->register_plugin(
                "leadgen-app-form",
                \__("LeadGen App Form", "leadgen-app-form"),
                [$this, "admin_page"],
                [
                    "description" => \__("Shortcode, Gutenberg block and Elementor widget for LeadGen App forms with responsive height controls.", "leadgen-app-form"),
                    "version" => LEADGEN_APP_FORM_VERSION,
                    "tab_title" => \__("LeadGen Forms", "leadgen-app-form"),
                    "capability" => "manage_options",
                    "plugin_file" => LEADGEN_APP_FORM_FILE,
                    "actions" => $actions,
                ]
            );
        } catch (\Exception $e) {
            \error_log("LeadGen App Form - Settings Hub registration failed: " . $e->getMessage());
            $this->add_standalone_menu();
        }
    }

  /**
   * Fallback: Register standalone menu when Settings Hub unavailable
   *
   * @return void
   */
    private function add_standalone_menu(): void
    {
        \add_options_page(
            \__("LeadGen App Form", "leadgen-app-form"),
            \__("LeadGen Forms", "leadgen-app-form"),
            "manage_options",
            "leadgen-app-form",
            [$this, "admin_page"]
        );
    }

  /**
   * Render update check script for Settings Hub action button
   *
   * Delegates to wp-github-updater's built-in enqueueCheckUpdatesScript() which
   * provides centralized JS, AJAX handling, admin notices, and auto-redirect.
   *
   * @since 1.1.0
   * @return void
   */
    public function render_update_check_script(): void
    {
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Inline JavaScript from wp-github-updater
        echo $this->updater->enqueueCheckUpdatesScript();
    }

  /**
   * Enqueue admin scripts
   *
   * @param string $hook Current admin page hook
   */
    public function enqueue_admin_scripts(string $hook): void
    {
        $allowed_hooks = [
            "settings_page_leadgen-app-form",
            "silver-assist_page_leadgen-app-form",
            "toplevel_page_leadgen-app-form",
        ];

        if (!\in_array($hook, $allowed_hooks, true)) {
            return;
        }

        \wp_enqueue_style(
            "leadgen-admin-css",
            LEADGEN_APP_FORM_PLUGIN_URL . "assets/css/admin-settings.css",
            [],
            LEADGEN_APP_FORM_VERSION
        );
    }

  /**
   * Render admin page
   */
    public function admin_page(): void
    {
        if (!\current_user_can("manage_options")) {
            return;
        }

        ?>
    <div class="wrap leadgen-admin">

      <div class="leadgen-settings-grid">


        <!-- Plugin Usage Card -->
        <div class="status-card">
          <div class="card-header">
            <span class="dashicons dashicons-editor-code"></span>
            <h3><?php \esc_html_e("Plugin Usage", "leadgen-app-form"); ?></h3>
          </div>
          <div class="card-content">
            <h3><?php \esc_html_e("Shortcode", "leadgen-app-form"); ?></h3>
            <p><?php \esc_html_e("Basic usage:", "leadgen-app-form"); ?></p>
            <code>[leadgen_form desktop-id="your-desktop-id" mobile-id="your-mobile-id"]</code>
            
            <p><?php \esc_html_e("With custom height:", "leadgen-app-form"); ?></p>
            <code>[leadgen_form desktop-id="id" mobile-id="id" desktop-height="800px" mobile-height="400px"]</code>
            
            <p class="description">
              <?php \esc_html_e("Supports: px, em, rem, vh, vw, %", "leadgen-app-form"); ?>
            </p>

            <h3><?php \esc_html_e("Gutenberg Block", "leadgen-app-form"); ?></h3>
            <p>
              <?php \esc_html_e("Search for 'LeadGen Form' in the block editor. Configure IDs and heights in the sidebar.", "leadgen-app-form"); ?>
            </p>

            <h3><?php \esc_html_e("Elementor Widget", "leadgen-app-form"); ?></h3>
            <p>
              <?php \esc_html_e("Drag 'LeadGen Form' from the 'LeadGen Forms' category in Elementor.", "leadgen-app-form"); ?>
            </p>
          </div>
        </div>

        <!-- How Updates Work Card -->
        <div class="status-card">
          <div class="card-header">
            <span class="dashicons dashicons-update"></span>
            <h3><?php \esc_html_e("How Updates Work", "leadgen-app-form"); ?></h3>
          </div>
          <div class="card-content">
            <ul class="feature-list">
              <li><?php \esc_html_e("WordPress automatically checks for updates every 12 hours", "leadgen-app-form"); ?></li>
              <li><?php \esc_html_e("Notifications appear in the Plugins page when updates are available", "leadgen-app-form"); ?></li>
              <li><?php \esc_html_e("Updates are downloaded directly from GitHub releases", "leadgen-app-form"); ?></li>
              <li><?php \esc_html_e("Settings and data are preserved during updates", "leadgen-app-form"); ?></li>
            </ul>
          </div>
        </div>


      </div>
    </div>
        <?php
    }
}
