<?php
/**
 * LeadGen Form Gutenberg Block Handler
 *
 * Handles registration and management of the LeadGen Form Gutenberg block.
 * Provides integration between WordPress block editor and the shortcode system.
 *
 * @package LeadGenAppForm\Block
 * @version 1.0.3
 * @since 1.0.0
 * @author Silver Assist
 */

namespace LeadGenAppForm\Block;

// Prevent direct access
if (!defined("ABSPATH")) {
  exit;
}

/**
 * Class LeadGenFormBlock
 *
 * Manages the Gutenberg block for LeadGen forms, including registration,
 * script enqueuing, and server-side rendering.
 *
 * @since 1.0.0
 * @package LeadGenAppForm\Block
 */
class LeadGenFormBlock
{

  /**
   * Single instance of the block handler
   *
   * @since 1.0.0
   * @var LeadGenFormBlock|null
   * @access private
   * @static
   */
  private static ?LeadGenFormBlock $instance = null;

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
   * @throws \Exception
   */
  public function __wakeup(): void
  {
    throw new \Exception("Cannot unserialize singleton");
  }

  /**
   * Get the single instance of the block handler
   *
   * Implements the Singleton pattern to ensure only one instance
   * of the block handler exists throughout the WordPress lifecycle.
   *
   * @since 1.0.0
   * @access public
   * @static
   * @return LeadGenFormBlock The single instance of the block handler
   */
  public static function get_instance(): LeadGenFormBlock
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Initialize the block handler
   *
   * Sets up hooks for block registration and script loading.
   * Called from the constructor.
   *
   * @since 1.0.0
   * @access private
   * @return void
   */
  private function init(): void
  {
    \add_action("init", [$this, "register_block"]);
    \add_action("enqueue_block_editor_assets", [$this, "enqueue_block_editor_assets"]);
  }

  /**
   * Register the Gutenberg block
   *
   * Registers the LeadGen form block with WordPress using block.json metadata.
   * Sets up server-side rendering callback for the block.
   *
   * @since 1.0.0
   * @access public
   * @return void
   */
  public function register_block(): void
  {
    // Register the block using block.json
    \register_block_type(
      LEADGEN_APP_FORM_PLUGIN_PATH . "blocks/leadgen-form/block.json",
      [
        "render_callback" => [$this, "render_block"]
      ]
    );
  }

  /**
   * Enqueue block editor assets
   *
   * Loads CSS and JavaScript files specifically for the block editor interface.
   * These assets are only loaded in the admin block editor context.
   *
   * @since 1.0.0
   * @access public
   * @return void
   */
  public function enqueue_block_editor_assets(): void
  {
    // Enqueue block editor CSS
    \wp_enqueue_style(
      "leadgen-form-block-editor",
      LEADGEN_APP_FORM_PLUGIN_URL . "blocks/leadgen-form/editor.css",
      [],
      LEADGEN_APP_FORM_VERSION
    );

    // Enqueue block JavaScript
    \wp_enqueue_script(
      "leadgen-form-block-js",
      LEADGEN_APP_FORM_PLUGIN_URL . "blocks/leadgen-form/block.js",
      ["wp-blocks", "wp-element", "wp-components", "wp-editor"],
      LEADGEN_APP_FORM_VERSION,
      true
    );
  }

  /**
   * Render the block on the frontend
   *
   * Server-side rendering callback for the Gutenberg block.
   * Converts block attributes to shortcode attributes and renders the form.
   *
   * @since 1.0.0
   * @access public
   * @param array $attributes {
   *     Block attributes from the editor.
   *
   *     @type string $desktopId     Desktop form ID.
   *     @type string $mobileId      Mobile form ID.
   *     @type string $desktopHeight Desktop placeholder height.
   *     @type string $mobileHeight  Mobile placeholder height.
   * }
   * @return string HTML output for the block
   */
  public function render_block(array $attributes): string
  {
    // Extract and sanitize attributes
    $desktop_id = \sanitize_text_field($attributes["desktopId"] ?? "");
    $mobile_id = \sanitize_text_field($attributes["mobileId"] ?? "");
    $desktop_height = \sanitize_text_field($attributes["desktopHeight"] ?? "");
    $mobile_height = \sanitize_text_field($attributes["mobileHeight"] ?? "");

    // Validate that at least one ID is present
    if (empty($desktop_id) && empty($mobile_id)) {
      return "<div class=\"leadgen-form-error\">" .
        \esc_html__("Error: At least one of the desktop or mobile form ID is required", "leadgen-app-form") .
        "</div>";
    }

    // Build shortcode attributes array
    $shortcode_atts = [];

    if (!empty($desktop_id)) {
      $shortcode_atts["desktop-id"] = $desktop_id;
    }

    if (!empty($mobile_id)) {
      $shortcode_atts["mobile-id"] = $mobile_id;
    }

    if (!empty($desktop_height)) {
      $shortcode_atts["desktop-height"] = $desktop_height;
    }

    if (!empty($mobile_height)) {
      $shortcode_atts["mobile-height"] = $mobile_height;
    }

    // Convert attributes array to shortcode string
    $shortcode_parts = [];
    foreach ($shortcode_atts as $key => $value) {
      $shortcode_parts[] = "{$key}=\"{$value}\"";
    }

    $shortcode_string = "[leadgen_form " . implode(" ", $shortcode_parts) . "]";

    // Use WordPress do_shortcode to render
    return \do_shortcode($shortcode_string);
  }

  /**
   * Get block configuration for JavaScript
   *
   * Returns block configuration data that can be used by JavaScript
   * for dynamic block management or frontend interactions.
   *
   * @since 1.0.0
   * @access public
   * @return array Block configuration array
   */
  public function get_block_config(): array
  {
    return [
      "name" => "leadgen-app-form/leadgen-form",
      "title" => \__("LeadGen Form", "leadgen-app-form"),
      "description" => \__("Display a LeadGen App form with responsive design", "leadgen-app-form"),
      "category" => "widgets",
      "supports" => [
        "html" => false,
        "multiple" => true,
        "reusable" => true
      ]
    ];
  }
}
