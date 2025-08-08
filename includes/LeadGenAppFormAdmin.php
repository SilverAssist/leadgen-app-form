<?php

/**
 * LeadGen App Form Admin Page - Plugin Settings and Update Status
 *
 * Provides admin interface for plugin settings and update status display.
 * Shows current version, available updates, and manual update check functionality.
 *
 * @package LeadGenAppForm
 * @since 1.0.1
 * @author Silver Assist
 * @version 1.0.6
 */

namespace LeadGenAppForm;

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
        \add_action("admin_menu", [$this, "add_admin_menu"]);
        \add_action("admin_enqueue_scripts", [$this, "enqueue_admin_scripts"]);
    }

  /**
   * Add admin menu page
   */
    public function add_admin_menu(): void
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
   * Enqueue admin scripts
   *
   * @param string $hook Current admin page hook
   */
    public function enqueue_admin_scripts(string $hook): void
    {
        if ($hook !== "settings_page_leadgen-app-form") {
            return;
        }

        \wp_enqueue_script(
            "leadgen-admin-js",
            LEADGEN_APP_FORM_PLUGIN_URL . "assets/js/leadgen-admin.js",
            ["jquery"],
            LEADGEN_APP_FORM_VERSION,
            true
        );

        \wp_localize_script("leadgen-admin-js", "leadgenAdmin", [
        "ajax_url" => \admin_url("admin-ajax.php"),
        "nonce" => \wp_create_nonce("leadgen_version_check"),
        "strings" => [
        "checking" => \__("Checking for updates...", "leadgen-app-form"),
        "error" => \__("Error checking for updates", "leadgen-app-form"),
        "upToDate" => \__("Plugin is up to date!", "leadgen-app-form"),
        "updateAvailable" => \__("Update available!", "leadgen-app-form")
        ]
        ]);
    }

  /**
   * Render admin page
   */
    public function admin_page(): void
    {
        if (!\current_user_can("manage_options")) {
            return;
        }

        $current_version = $this->updater->get_current_version();
        $github_repo = $this->updater->get_github_repo();
        ?>
    <div class="wrap">
      <h1><?php echo \esc_html(\get_admin_page_title()); ?></h1>

      <div class="card" style="max-width: 600px;">
        <h2><?php \esc_html_e("Plugin Information", "leadgen-app-form"); ?></h2>
        <table class="form-table">
          <tr>
            <th scope="row"><?php \esc_html_e("Current Version", "leadgen-app-form"); ?></th>
            <td><strong><?php echo \esc_html($current_version); ?></strong></td>
          </tr>
          <tr>
            <th scope="row"><?php \esc_html_e("Repository", "leadgen-app-form"); ?></th>
            <td>
              <a href="https://github.com/<?php echo \esc_attr($github_repo); ?>" target="_blank" rel="noopener">
                <?php echo \esc_html($github_repo); ?>
                <span class="dashicons dashicons-external"></span>
              </a>
            </td>
          </tr>
          <tr>
            <th scope="row"><?php \esc_html_e("Update Status", "leadgen-app-form"); ?></th>
            <td>
              <div id="update-status">
                <span class="spinner"></span>
                <?php \esc_html_e("Checking for updates...", "leadgen-app-form"); ?>
              </div>
              <p class="description">
                <?php \esc_html_e("Updates are checked automatically. You can also check manually using the button below.", "leadgen-app-form"); ?>
              </p>
            </td>
          </tr>
        </table>

        <p class="submit">
          <button type="button" id="check-updates" class="button button-secondary">
            <?php \esc_html_e("Check for Updates", "leadgen-app-form"); ?>
          </button>
        </p>
      </div>

      <div class="card" style="max-width: 600px;">
        <h2><?php \esc_html_e("How Updates Work", "leadgen-app-form"); ?></h2>
        <ul>
          <li><?php \esc_html_e("WordPress automatically checks for updates every 12 hours", "leadgen-app-form"); ?></li>
          <li>
            <?php \esc_html_e("When an update is available, you'll see a notification in the Plugins page", "leadgen-app-form"); ?>
          </li>
          <li><?php \esc_html_e("Updates are downloaded directly from GitHub releases", "leadgen-app-form"); ?></li>
          <li><?php \esc_html_e("Your plugin settings and data are preserved during updates", "leadgen-app-form"); ?></li>
        </ul>
      </div>

      <div class="card" style="max-width: 600px;">
        <h2><?php \esc_html_e("Plugin Usage", "leadgen-app-form"); ?></h2>
        <h3><?php \esc_html_e("Shortcode", "leadgen-app-form"); ?></h3>
        <p><?php \esc_html_e("Basic usage:", "leadgen-app-form"); ?></p>
        <code>[leadgen_form desktop-id="your-desktop-id" mobile-id="your-mobile-id"]</code>
        
        <p><?php \esc_html_e("With custom height (new in v1.0.3):", "leadgen-app-form"); ?></p>
        <code>[leadgen_form desktop-id="your-desktop-id" mobile-id="your-mobile-id" desktop-height="800px" mobile-height="400px"]</code>
        
        <p class="description">
          <?php \esc_html_e("Supports multiple units: px, em, rem, vh, vw, % (e.g., \"50vh\", \"80%\")", "leadgen-app-form"); ?>
        </p>

        <h3><?php \esc_html_e("Gutenberg Block", "leadgen-app-form"); ?></h3>
        <p>
          <?php \esc_html_e("Search for 'LeadGen Form' in the block editor and configure your form IDs and custom heights in the sidebar.", "leadgen-app-form"); ?>
        </p>

        <h3><?php \esc_html_e("Elementor Widget", "leadgen-app-form"); ?></h3>
        <p>
          <?php \esc_html_e("Drag the 'LeadGen Form' widget from the 'LeadGen Forms' category in Elementor. Configure height settings with professional controls.", "leadgen-app-form"); ?>
        </p>
      </div>
    </div>

    <style>
      .update-available {
        color: #d63638;
        font-weight: bold;
      }

      .update-current {
        color: #00a32a;
        font-weight: bold;
      }

      .spinner.is-active {
        visibility: visible;
      }
    </style>
        <?php
    }
}
