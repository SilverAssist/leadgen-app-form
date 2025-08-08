<?php
/**
 * LeadGen App Form Plugin - Elementor Widgets Loader
 *
 * This class handles the registration and loading of Elementor widgets
 * for the LeadGen App Form plugin. It ensures widgets are only loaded
 * when Elementor is active and provides proper integration.
 *
 * @package LeadGenAppForm\Elementor
 * @version 1.0.6
 * @since 1.0.0
 * @author Silver Assist
 */

namespace LeadGenAppForm\Elementor;

defined("ABSPATH") or exit;

use Elementor\Plugin;
use Elementor\Elements_Manager;
use Elementor\Widgets_Manager;

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
   * Single instance of the loader
   *
   * @since 1.0.0
   * @var WidgetsLoader|null
   * @access private
   * @static
   */
  private static ?WidgetsLoader $instance = null;

  /**
   * Get the single instance of the widgets loader
   *
   * Implements the Singleton pattern to ensure only one instance
   * of the widgets loader exists throughout the lifecycle.
   *
   * @since 1.0.0
   * @access public
   * @static
   * @return WidgetsLoader The single instance of the loader
   */
  public static function get_instance(): WidgetsLoader
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Constructor
   *
   * Sets up hooks for widget registration and category creation.
   * Only initializes if Elementor is active and loaded.
   *
   * @since 1.0.0
   * @access private
   */
  private function __construct()
  {
    // Check if Elementor is active before proceeding
    if (!$this->is_elementor_loaded()) {
      return;
    }

    $this->init_hooks();
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
   * @throws \Exception
   */
  public function __wakeup(): void
  {
    throw new \Exception("Cannot unserialize singleton");
  }

  /**
   * Check if Elementor is loaded and active
   *
   * @since 1.0.0
   * @access private
   * @return bool True if Elementor is loaded, false otherwise
   */
  private function is_elementor_loaded(): bool
  {
    return \did_action("elementor/loaded");
  }

  /**
   * Initialize WordPress hooks
   *
   * Sets up the necessary actions for registering widgets, categories,
   * and frontend assets with proper priority and timing.
   *
   * @since 1.0.0
   * @access private
   * @return void
   */
  private function init_hooks(): void
  {
    // Register widgets when Elementor widgets are registered
    \add_action("elementor/widgets/register", [$this, "register_widgets"]);

    // Register widget category
    \add_action("elementor/elements/categories_registered", [$this, "register_widget_category"]);

    // Register frontend scripts and styles
    \add_action("elementor/frontend/after_register_scripts", [$this, "register_frontend_scripts"]);
  }

  /**
   * Get the list of available widgets
   *
   * Returns an array of widget class names that should be registered
   * with Elementor. This allows for easy management of widgets.
   *
   * @since 1.0.0
   * @access public
   * @static
   * @return array Array of widget class names
   */
  public static function get_widget_list(): array
  {
    return [
      "leadgen-form" => "LeadGenFormWidget",
    ];
  }

  /**
   * Include widget files
   *
   * Loads the PHP files containing widget class definitions.
   * Uses the widget list to dynamically include files.
   *
   * @since 1.0.0
   * @access private
   * @return void
   */
  private function include_widget_files(): void
  {
    $widget_list = self::get_widget_list();

    foreach ($widget_list as $widget_key => $widget_class) {
      $widget_file = LEADGEN_APP_FORM_PLUGIN_PATH . "includes/elementor/widgets/{$widget_class}.php";
      if (\file_exists($widget_file)) {
        require_once $widget_file;
      }
    }
  }

  /**
   * Register custom widget category
   *
   * Creates a dedicated category for LeadGen widgets in the Elementor
   * widgets panel for better organization and user experience.
   *
   * @since 1.0.0
   * @access public
   * @param Elements_Manager $elements_manager The Elementor elements manager
   * @return void
   */
  public function register_widget_category(Elements_Manager $elements_manager): void
  {
    $elements_manager->add_category(
      "leadgen-forms",
      [
        "title" => __("LeadGen Forms", "leadgen-app-form"),
        "icon" => "eicon-form-horizontal",
      ]
    );
  }

  /**
   * Register widgets with Elementor
   *
   * Includes widget files and registers each widget with Elementor's
   * widget manager. Uses the widget list for dynamic registration.
   *
   * @since 1.0.0
   * @access public
   * @param Widgets_Manager $widgets_manager Elementor widgets manager
   * @return void
   */
  public function register_widgets(Widgets_Manager $widgets_manager): void
  {
    // Include widget files
    $this->include_widget_files();

    // Register widgets
    $widget_list = self::get_widget_list();

    foreach ($widget_list as $widget_key => $widget_class) {
      $widget_class_name = "LeadGenAppForm\\Elementor\\Widgets\\{$widget_class}";

      if (\class_exists($widget_class_name)) {
        $widgets_manager->register(new $widget_class_name());
      }
    }
  }

  /**
   * Register frontend scripts and styles
   *
   * Registers CSS and JavaScript files needed for Elementor widgets
   * on the frontend. Uses the existing plugin assets with proper versioning.
   *
   * @since 1.0.0
   * @access public
   * @return void
   */
  public function register_frontend_scripts(): void
  {
    // Register CSS for Elementor specific styles
    \wp_register_style(
      "leadgen-elementor-css",
      LEADGEN_APP_FORM_PLUGIN_URL . "assets/css/leadgen-elementor.css",
      ["leadgen-app-form-css"],
      LEADGEN_APP_FORM_VERSION
    );

    // The main plugin scripts are already registered in the main class
    // We just need to ensure they're available for Elementor widgets
  }

  /**
   * Check if we're in Elementor editor mode
   *
   * Utility method to determine if the current request is from
   * the Elementor editor interface.
   *
   * @since 1.0.0
   * @access public
   * @return bool True if in Elementor editor, false otherwise
   */
  public function is_elementor_editor(): bool
  {
    return \class_exists("\\Elementor\\Plugin") && Plugin::$instance->editor->is_edit_mode();
  }

  /**
   * Get Elementor plugin instance
   *
   * Safe wrapper to get the Elementor plugin instance with
   * proper checks to avoid fatal errors.
   *
   * @since 1.0.0
   * @access public
   * @return Plugin|null Elementor plugin instance or null
   */
  public function get_elementor_instance(): ?Plugin
  {
    if (\class_exists("\\Elementor\\Plugin")) {
      return Plugin::$instance;
    }

    return null;
  }
}
