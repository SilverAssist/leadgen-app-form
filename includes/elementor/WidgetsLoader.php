<?php

/**
 * LeadGen App Form Plugin - Elementor Widgets Loader
 *
 * This class handles the registration and loading of Elementor widgets
 * for the LeadGen App Form plugin. It ensures widgets are only loaded
 * when Elementor is active and provides proper integration.
 *
 * @package LeadGenAppForm\Elementor
 * @version 1.0.3
 * @since 1.0.0
 * @author Silver Assist
 */

namespace LeadGenAppForm\Elementor;

defined("ABSPATH") or exit;

use Elementor\Plugin;
use Elementor\Elements_Manager;

/**
 * Elementor Widgets Loader
 *
 * Manages the registration of custom Elementor widgets for LeadGen forms.
 * Implements singleton pattern for consistent integration and handles
 * widget categories, scripts, and styles registration.
 *
 * @since 1.0.0
 */
class WidgetsLoader
{
  /**
   * Single instance of the widgets loader
   *
   * @var WidgetsLoader|null
   * @access private
   * @static
   */
    private static ?WidgetsLoader $instance = null;

  /**
   * Private constructor to prevent direct instantiation
   *
   * @access private
   */
    private function __construct()
    {
        $this->init();
    }

  /**
   * Prevent object cloning
   *
   * @access private
   */
    private function __clone(): void
    {
    }

  /**
   * Prevent object unserialization
   *
   * @access public
   * @throws \Exception
   */
    public function __wakeup(): void
    {
        throw new \Exception("Cannot unserialize singleton");
    }

  /**
   * Get the single instance of the widgets loader
   *
   * @access public
   * @static
   * @return WidgetsLoader
   */
    public static function get_instance(): WidgetsLoader
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

  /**
   * Initialize the widgets loader
   *
   * Sets up hooks and checks if Elementor is active before proceeding
   * with widget registration.
   *
   * @access private
   * @return void
   */
    private function init(): void
    {
      // Check if Elementor is installed and active
        if (!$this->is_elementor_loaded()) {
            return;
        }

      // Initialize when Elementor is ready
        \add_action("elementor/init", [$this, "elementor_init"]);
    }

  /**
   * Check if Elementor is loaded
   *
   * Verifies that Elementor plugin is active and available for use.
   *
   * @access private
   * @return bool True if Elementor is loaded, false otherwise
   */
    private function is_elementor_loaded(): bool
    {
        return \did_action("elementor/loaded") || \class_exists("\\Elementor\\Plugin");
    }

  /**
   * Initialize Elementor integration
   *
   * Called when Elementor is ready. Sets up widget registration,
   * categories, and required scripts/styles.
   *
   * @access public
   * @return void
   */
    public function elementor_init(): void
    {
      // Register widget category
        \add_action("elementor/elements/categories_registered", [$this, "register_widget_category"]);

      // Register widgets
        \add_action("elementor/widgets/register", [$this, "register_widgets"]);

      // Enqueue Elementor-specific styles
        \add_action("elementor/frontend/after_enqueue_styles", [$this, "enqueue_elementor_styles"]);

      // Enqueue editor scripts (for better UX in Elementor editor)
        \add_action("elementor/editor/before_enqueue_scripts", [$this, "enqueue_editor_scripts"]);
    }

  /**
   * Register custom widget category
   *
   * Creates a dedicated category for LeadGen widgets in the Elementor panel.
   *
   * @access public
   * @param Elements_Manager $elements_manager Elementor elements manager
   * @return void
   */
    public function register_widget_category(Elements_Manager $elements_manager): void
    {
        $elements_manager->add_category("leadgen-forms", [
        "title" => \esc_html__("LeadGen Forms", "leadgen-app-form"),
        "icon" => "fa fa-plug"
        ]);
    }

  /**
   * Register widgets
   *
   * Loads and registers all LeadGen widgets with Elementor.
   *
   * @access public
   * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager
   * @return void
   */
    public function register_widgets(\Elementor\Widgets_Manager $widgets_manager): void
    {
      // Load widget files
        $this->load_widget_files();

      // Register LeadGen Form Widget
        if (\class_exists("LeadGenAppForm\\Elementor\\Widgets\\LeadGenFormWidget")) {
            $widgets_manager->register(new Widgets\LeadGenFormWidget());
        }
    }

  /**
   * Load widget files
   *
   * Includes all widget class files from the widgets directory.
   *
   * @access private
   * @return void
   */
    private function load_widget_files(): void
    {
      // Load LeadGen Form Widget
        require_once LEADGEN_APP_FORM_PLUGIN_PATH . "includes/elementor/widgets/LeadGenFormWidget.php";
    }

  /**
   * Enqueue Elementor-specific styles
   *
   * Loads CSS files that are specific to Elementor integration.
   * These styles ensure proper appearance in Elementor contexts.
   *
   * @access public
   * @return void
   */
    public function enqueue_elementor_styles(): void
    {
        \wp_enqueue_style(
            "leadgen-elementor-css",
            LEADGEN_APP_FORM_PLUGIN_URL . "assets/css/leadgen-elementor.css",
            [],
            LEADGEN_APP_FORM_VERSION
        );
    }

  /**
   * Enqueue editor scripts
   *
   * Loads JavaScript files for enhanced Elementor editor experience.
   * These scripts improve the widget configuration interface.
   *
   * @access public
   * @return void
   */
    public function enqueue_editor_scripts(): void
    {
      // Enqueue any editor-specific scripts if needed
      // Currently, the main plugin JS handles most functionality
    }

  /**
   * Get registered widgets list
   *
   * Returns an array of all widgets registered by this loader.
   * Useful for debugging and widget management.
   *
   * @access public
   * @return array List of registered widget class names
   */
    public function get_registered_widgets(): array
    {
        return [
        "LeadGenAppForm\\Elementor\\Widgets\\LeadGenFormWidget"
        ];
    }

  /**
   * Check if widget exists
   *
   * Verifies if a specific widget class is available and registered.
   *
   * @access public
   * @param string $widget_class Widget class name to check
   * @return bool True if widget exists, false otherwise
   */
    public function widget_exists(string $widget_class): bool
    {
        return \class_exists($widget_class);
    }

  /**
   * Get widget configuration
   *
   * Returns configuration data for widgets that can be used
   * by JavaScript or other components.
   *
   * @access public
   * @return array Widget configuration array
   */
    public function get_widget_config(): array
    {
        return [
        "category" => "leadgen-forms",
        "base_url" => LEADGEN_APP_FORM_PLUGIN_URL,
        "version" => LEADGEN_APP_FORM_VERSION,
        "widgets" => $this->get_registered_widgets()
        ];
    }

  /**
   * Force reload widgets
   *
   * Utility method to force Elementor to reload all widgets.
   * Useful during development or after widget updates.
   *
   * @access public
   * @return void
   */
    public function force_reload_widgets(): void
    {
        if (\class_exists("\\Elementor\\Plugin")) {
            Plugin::$instance->widgets_manager->ajax_register_widget_type();
        }
    }
}
