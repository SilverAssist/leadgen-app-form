<?php

/**
 * Plugin Name: LeadGen App Form Plugin
 * Plugin URI: https://github.com/SilverAssist/leadgen-app-form
 * Description: WordPress plugin that adds a shortcode to display LeadGen App forms with desktop-id and mobile-id parameters.
 * Version: 1.0.5
 * Author: Silver Assist
 * Author URI: http://silverassist.com/
 * Text Domain: leadgen-app-form
 * Domain Path: /languages
 * Requires PHP: 8.0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package LeadGenAppForm
 * @version 1.0.5
 * @author Silver Assist
 */

namespace LeadGenAppForm;

// Import WordPress core classes
use WP_Post;
// Import PHP standard classes
use Exception;

// Prevent direct access
if (!defined("ABSPATH")) {
    exit;
}

// Define plugin constants
define("LEADGEN_APP_FORM_VERSION", "1.0.5");
define("LEADGEN_APP_FORM_PLUGIN_URL", plugin_dir_url(__FILE__));
define("LEADGEN_APP_FORM_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("LEADGEN_APP_FORM_PLUGIN_BASENAME", plugin_basename(__FILE__));

/**
 * Main plugin class using Singleton pattern
 *
 * Handles the core functionality of the LeadGen App Form plugin,
 * including shortcode registration, script/style loading, and form rendering.
 *
 * @since 1.0.0
 * @package LeadGenAppForm
 */
class LeadGen_App_Form
{
  /**
   * Single instance of the plugin
   *
   * @since 1.0.0
   * @var LeadGen_App_Form|null
   * @access private
   * @static
   */
    private static ?LeadGen_App_Form $instance = null;

  /**
   * Private constructor to prevent direct instantiation
   *
   * @since 1.0.0
   * @access private
   */
    private function __construct()
    {
        $this->init();
    }

  /**
   * Prevent object cloning
   *
   * @since 1.0.0
   * @access private
   */
    private function __clone(): void
    {
    }

  /**
   * Prevent object unserialization
   *
   * @since 1.0.0
   * @access public
   * @throws Exception
   */
    public function __wakeup(): void
    {
        throw new Exception("Cannot unserialize singleton");
    }

  /**
   * Get the single instance of the plugin
   *
   * Implements the Singleton pattern to ensure only one instance
   * of the plugin exists throughout the WordPress lifecycle.
   *
   * @since 1.0.0
   * @access public
   * @static
   * @return LeadGen_App_Form The single instance of the plugin
   */
    public static function get_instance(): LeadGen_App_Form
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

  /**
   * Initialize the plugin
   *
   * Sets up hooks, loads dependencies, and registers the shortcode.
   * Called from the constructor.
   *
   * @since 1.0.0
   * @access private
   * @return void
   */
    private function init(): void
    {
      // Load necessary files
        $this->load_dependencies();

      // WordPress hooks
        add_action("init", [$this, "init_plugin"]);
        add_action("wp_enqueue_scripts", [$this, "enqueue_scripts"]);

      // Register shortcode
        add_shortcode("leadgen_form", [$this, "render_shortcode"]);
    }

  /**
   * Load plugin dependencies
   *
   * Include additional PHP files from the includes directory.
   * Loads the Gutenberg block handler, Elementor widgets loader, and updater system.
   *
   * @since 1.0.0
   * @access private
   * @return void
   */
    private function load_dependencies(): void
    {
      // Load Gutenberg block handler
        require_once LEADGEN_APP_FORM_PLUGIN_PATH . "includes/LeadGenFormBlock.php";

      // Load Elementor widgets loader (only if Elementor is active)
        if (\did_action("elementor/loaded") || \class_exists("\\Elementor\\Plugin")) {
            require_once LEADGEN_APP_FORM_PLUGIN_PATH . "includes/elementor/WidgetsLoader.php";
        }

      // Load updater system (only in admin)
        if (\is_admin()) {
            require_once LEADGEN_APP_FORM_PLUGIN_PATH . "includes/LeadGenAppFormUpdater.php";
            require_once LEADGEN_APP_FORM_PLUGIN_PATH . "includes/LeadGenAppFormAdmin.php";
        }
    }

  /**
   * Initialize plugin after WordPress is loaded
   *
   * Loads the plugin textdomain for internationalization support,
   * initializes the Gutenberg block handler, sets up Elementor integration,
   * and initializes the updater system.
   * This method is called on the "init" hook.
   *
   * @since 1.0.0
   * @access public
   * @return void
   */
    public function init_plugin(): void
    {
      // Load textdomain for translations
        \load_plugin_textdomain(
            "leadgen-app-form",
            false,
            dirname(LEADGEN_APP_FORM_PLUGIN_BASENAME) . "/languages"
        );

      // Initialize Gutenberg block
        if (\class_exists("LeadGenAppForm\\Block\\LeadGenFormBlock")) {
            Block\LeadGenFormBlock::get_instance();
        }

      // Initialize Elementor widgets loader
        if (\class_exists("LeadGenAppForm\\Elementor\\WidgetsLoader")) {
            Elementor\WidgetsLoader::get_instance();
        }

      // Initialize updater system (only in admin)
        if (\is_admin() && \class_exists("LeadGenAppForm\\LeadGenAppFormUpdater")) {
          // Public repository - no authentication required
            $updater = new LeadGenAppFormUpdater(__FILE__, "SilverAssist/leadgen-app-form");

          // Initialize admin page
            if (\class_exists("LeadGenAppForm\\LeadGenAppFormAdmin")) {
                new LeadGenAppFormAdmin($updater);
            }
        }
    }

  /**
   * Load scripts and styles
   *
   * Conditionally enqueues CSS and JavaScript files only when the shortcode
   * is present on the current page or when Elementor widgets are detected.
   * Also localizes script with global settings.
   *
   * @since 1.0.0
   * @access public
   * @global WP_Post $post The current post object
   * @return void
   */
    public function enqueue_scripts(): void
    {
      // Register CSS
        wp_register_style(
            "leadgen-app-form-css",
            LEADGEN_APP_FORM_PLUGIN_URL . "assets/css/leadgen-app-form.css",
            [],
            LEADGEN_APP_FORM_VERSION
        );

      // Register JavaScript
        wp_register_script(
            "leadgen-app-form-js",
            LEADGEN_APP_FORM_PLUGIN_URL . "assets/js/leadgen-app-form.js",
            ["jquery"],
            LEADGEN_APP_FORM_VERSION,
            true
        );

        global $post;
        $should_load_scripts = false;
        $shortcode_instances = [];

      // Check if shortcode is present in post content
        if (is_a($post, WP_Post::class) && has_shortcode($post->post_content, "leadgen_form")) {
            $should_load_scripts = true;
            $shortcode_instances = $this->extract_shortcode_instances($post->post_content);
        }

      // Check if Elementor widgets are present
        if (!$should_load_scripts && $this->has_elementor_widgets()) {
            $should_load_scripts = true;
          // For Elementor widgets, we'll let JavaScript handle the initialization
          // since the widget data is available in the DOM
        }

        if ($should_load_scripts) {
            wp_enqueue_style("leadgen-app-form-css");
            wp_enqueue_script("leadgen-app-form-js");

          // Localize script with global settings
            wp_localize_script("leadgen-app-form-js", "leadGenAppSettings", [
            "ajax_url" => admin_url("admin-ajax.php"),
            "nonce" => wp_create_nonce("leadgen_form_nonce"),
            "instances" => $shortcode_instances,
            "base_form_url" => "https://forms.leadgenapp.io/js/lf.min.js/"
            ]);
        }
    }

  /**
   * Render the shortcode
   *
   * Processes shortcode attributes and generates HTML output for the form container.
   * Validates parameters, detects device type, and creates unique instance IDs.
   *
   * @since 1.0.0
   * @access public
   * @param array|string $atts {
   *     Shortcode attributes.
   *
   *     @type string $desktop-id     Optional. Form ID for desktop devices.
   *     @type string $mobile-id      Optional. Form ID for mobile devices.
   *     @type string $desktop-height Optional. Placeholder height for desktop devices (e.g., "500px").
   *     @type string $mobile-height  Optional. Placeholder height for mobile devices (e.g., "350px").
   * }
   * @return string HTML output for the shortcode
   */
    public function render_shortcode($atts): string
    {
      // Default attributes
        $atts = shortcode_atts([
        "desktop-id" => "",
        "mobile-id" => "",
        "desktop-height" => "",
        "mobile-height" => ""
        ], $atts, "leadgen_form");

      // Validate that at least one ID is present
        if (empty($atts["desktop-id"]) && empty($atts["mobile-id"])) {
            return "<div class=\"leadgen-form-error\">" .
            esc_html__("Error: At least one of the desktop-id or mobile-id parameters is required", "leadgen-app-form") .
            "</div>";
        }

      // Sanitize attributes using null coalescing
        $desktop_id = \sanitize_text_field($atts["desktop-id"] ?? "");
        $mobile_id = \sanitize_text_field($atts["mobile-id"] ?? "");
        $desktop_height = \sanitize_text_field($atts["desktop-height"] ?? "");
        $mobile_height = \sanitize_text_field($atts["mobile-height"] ?? "");

      // Detect if mobile device
        $is_mobile = \wp_is_mobile();

      // Determine current ID using PHP 8 match expression for cleaner logic
        $current_id = match (true) {
            $is_mobile && !empty($mobile_id) => $mobile_id,
            !empty($desktop_id) => $desktop_id,
            !empty($mobile_id) => $mobile_id,
            default => ""
        };

      // Create unique ID for this shortcode instance
        $instance_id = "leadgen-form-" . \wp_generate_uuid4();

      // Generate form HTML using output buffering
        ob_start();
        ?>
    <div class="leadgen-form-container" id="<?php echo \esc_attr($instance_id); ?>"
      data-desktop-id="<?php echo \esc_attr($desktop_id); ?>" data-mobile-id="<?php echo \esc_attr($mobile_id); ?>"
      data-desktop-height="<?php echo \esc_attr($desktop_height); ?>" data-mobile-height="<?php echo \esc_attr($mobile_height); ?>"
      data-current-id="<?php echo \esc_attr($current_id); ?>" data-is-mobile="<?php echo $is_mobile ? "1" : "0"; ?>">

      <div class="leadgen-form-wrapper">
        <!-- Placeholder with pulse animation -->
        <div class="leadgen-form-placeholder">
          <div class="leadgen-pulse-animation"></div>
        </div>
        <!-- Form container -->
        <div id="leadgen-form-wrap-<?php echo \esc_attr($current_id); ?>" class="leadgen-form-content"
          style="display: none;">
          <!-- The form will be dynamically inserted here -->
        </div>
      </div>

    </div>
        <?php
        return ob_get_clean();
    }

  /**
   * Extract shortcode instances from post content
   *
   * Parses the post content to find all instances of the leadgen_form shortcode
   * and extracts their attributes for JavaScript configuration.
   *
   * @since 1.0.0
   * @access private
   * @param string $content The post content to parse
   * @return array {
   *     Array of shortcode instances with their configurations.
   *
   *     @type array ...$0 {
   *         Individual shortcode instance.
   *
   *         @type string $desktop_id     Desktop form ID.
   *         @type string $mobile_id      Mobile form ID.
   *         @type string $desktop_height Desktop placeholder height.
   *         @type string $mobile_height  Mobile placeholder height.
   *         @type int    $index          Index of the shortcode instance.
   *     }
   * }
   */
    private function extract_shortcode_instances($content): array
    {
        $instances = [];

      // Pattern to find leadgen_form shortcodes
        $pattern = "/\[leadgen_form\s+([^\]]*)\]/";

        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $index => $match) {
                // Parse shortcode attributes
                $atts = shortcode_parse_atts($match[1]);

                if ($atts) {
                    $desktop_id = \sanitize_text_field($atts["desktop-id"] ?? "");
                    $mobile_id = \sanitize_text_field($atts["mobile-id"] ?? "");
                    $desktop_height = \sanitize_text_field($atts["desktop-height"] ?? "");
                    $mobile_height = \sanitize_text_field($atts["mobile-height"] ?? "");

                  // Only add if at least one ID is present
                    if (!empty($desktop_id) || !empty($mobile_id)) {
                        $instances[] = [
                        "desktop_id" => $desktop_id,
                        "mobile_id" => $mobile_id,
                        "desktop_height" => $desktop_height,
                        "mobile_height" => $mobile_height,
                        "index" => $index
                        ];
                    }
                }
            }
        }

        return $instances;
    }

  /**
   * Check if Elementor LeadGen widgets are present on the current page
   *
   * Searches for Elementor data to detect if any LeadGen form widgets are active.
   * This is used to determine if scripts should be loaded when shortcodes aren't present.
   *
   * @since 1.0.0
   * @access private
   * @return bool True if Elementor widgets are detected, false otherwise
   */
    private function has_elementor_widgets(): bool
    {
      // Early return if Elementor is not active
        if (!class_exists("\\Elementor\\Plugin")) {
            return false;
        }

        global $post;
        if (!is_a($post, WP_Post::class)) {
            return false;
        }

      // Check if this is an Elementor page
        $elementor_data = get_post_meta($post->ID, "_elementor_data", true);

        if (empty($elementor_data)) {
            return false;
        }

      // Parse Elementor data (it"s stored as JSON)
        $elementor_data = json_decode($elementor_data, true);

        if (!is_array($elementor_data)) {
            return false;
        }

      // Recursively search for our widget in the Elementor data
        return $this->search_elementor_data_for_widget($elementor_data, "leadgen-form");
    }

  /**
   * Recursively search Elementor data for specific widget type
   *
   * Searches through the nested Elementor data structure to find widgets
   * of a specific type (widget name).
   *
   * @since 1.0.0
   * @access private
   * @param array $data The Elementor data array to search
   * @param string $widget_name The widget name to search for
   * @return bool True if widget is found, false otherwise
   */
    private function search_elementor_data_for_widget(array $data, string $widget_name): bool
    {
        foreach ($data as $element) {
            if (!is_array($element)) {
                continue;
            }

          // Check if this element is our widget
            if (isset($element["widgetType"]) && $element["widgetType"] === $widget_name) {
                return true;
            }

          // Check elType for backwards compatibility
            if (
                isset($element["elType"]) && $element["elType"] === "widget" &&
                isset($element["widgetType"]) && $element["widgetType"] === $widget_name
            ) {
                return true;
            }

          // Recursively search in elements (for sections, columns, etc.)
            if (isset($element["elements"]) && is_array($element["elements"])) {
                if ($this->search_elementor_data_for_widget($element["elements"], $widget_name)) {
                    return true;
                }
            }
        }

        return false;
    }
}

/**
 * Initialize the plugin
 *
 * Factory function to get the singleton instance of the plugin.
 * This function is called on the "plugins_loaded" hook.
 *
 * @since 1.0.0
 * @return LeadGen_App_Form The single instance of the plugin
 */
function leadgen_app_form_init(): LeadGen_App_Form
{
    return LeadGen_App_Form::get_instance();
}

// Initialize the plugin when WordPress is ready
\add_action("plugins_loaded", "LeadGenAppForm\\leadgen_app_form_init");
