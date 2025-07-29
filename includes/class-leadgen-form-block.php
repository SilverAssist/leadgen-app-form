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
 * Class LeadGen_Form_Block
 *
 * Manages the Gutenberg block for LeadGen forms, including registration,
 * script enqueuing, and server-side rendering.
 */
class LeadGen_Form_Block
{

  /**
   * Single instance of the block handler
   *
   * @since 1.0.0
   * @var LeadGen_Form_Block|null
   * @access private
   * @static
   */
  private static ?LeadGen_Form_Block $instance = null;

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
   * Get the single instance of the block handler
   *
   * @since 1.0.0
   * @access public
   * @static
   * @return LeadGen_Form_Block The single instance
   */
  public static function get_instance(): LeadGen_Form_Block
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Initialize the block handler
   *
   * Sets up WordPress hooks and registers the block.
   *
   * @since 1.0.0
   * @access private
   * @return void
   */
  private function init(): void
  {
    // Hook into WordPress
    add_action("init", [$this, "register_block"]);
    add_action("enqueue_block_editor_assets", [$this, "enqueue_editor_assets"]);
  }

  /**
   * Register the LeadGen Form block
   *
   * Registers the block with WordPress using register_block_type.
   * Sets up server-side rendering and block attributes.
   *
   * @since 1.0.0
   * @access public
   * @return void
   */
  public function register_block(): void
  {
    // Check if Gutenberg is available
    if (!\function_exists("register_block_type")) {
      return;
    }

    \register_block_type("leadgen/form-block", [
      "attributes" => [
        "desktopId" => [
          "type" => "string",
          "default" => ""
        ],
        "mobileId" => [
          "type" => "string",
          "default" => ""
        ]
      ],
      "render_callback" => [$this, "render_block"],
      "editor_script" => "leadgen-form-block-editor",
      "editor_style" => "leadgen-form-block-editor-style"
    ]);
  }

  /**
   * Enqueue editor assets
   *
   * Loads JavaScript and CSS files needed for the block editor.
   * Only loads in the admin editor context.
   *
   * @since 1.0.0
   * @access public
   * @return void
   */
  public function enqueue_editor_assets(): void
  {
    // Enqueue block JavaScript
    \wp_enqueue_script(
      "leadgen-form-block-editor",
      LEADGEN_APP_FORM_PLUGIN_URL . "blocks/leadgen-form/block.js",
      [
        "wp-blocks",
        "wp-element",
        "wp-components",
        "wp-i18n",
        "wp-block-editor"
      ],
      LEADGEN_APP_FORM_VERSION,
      true
    );

    // Enqueue block editor styles
    \wp_enqueue_style(
      "leadgen-form-block-editor-style",
      LEADGEN_APP_FORM_PLUGIN_URL . "blocks/leadgen-form/editor.css",
      ["wp-edit-blocks"],
      LEADGEN_APP_FORM_VERSION
    );

    // Localize script with translations
    if (\function_exists("wp_set_script_translations")) {
      \wp_set_script_translations(
        "leadgen-form-block-editor",
        "leadgen-app-form",
        LEADGEN_APP_FORM_PLUGIN_PATH . "languages"
      );
    }
  }

  /**
   * Render the block on the frontend
   *
   * Server-side rendering function that converts block attributes
   * into the appropriate shortcode output using PHP 8 features.
   *
   * @since 1.0.0
   * @access public
   * @param array $attributes {
   *     Block attributes.
   *
   *     @type string $desktopId Desktop form ID.
   *     @type string $mobileId  Mobile form ID.
   * }
   * @return string HTML output for the block
   */
  public function render_block(array $attributes): string
  {
    // Extract attributes with defaults using null coalescing
    $desktop_id = \sanitize_text_field($attributes["desktopId"] ?? "");
    $mobile_id = \sanitize_text_field($attributes["mobileId"] ?? "");

    // Validate that at least one ID is present
    if (empty($desktop_id) && empty($mobile_id)) {
      return "";
    }

    // Build shortcode attributes using PHP 8 array spread
    $shortcode_atts = [
      ...(!empty($desktop_id) ? ["desktop-id=\"{$desktop_id}\""] : []),
      ...(!empty($mobile_id) ? ["mobile-id=\"{$mobile_id}\""] : [])
    ];

    // Generate and execute shortcode
    $shortcode = "[leadgen_form " . implode(" ", $shortcode_atts) . "]";

    return \do_shortcode($shortcode);
  }

  /**
   * Check if the current screen is the block editor
   *
   * Helper method to determine if we're in the Gutenberg editor context.
   *
   * @since 1.0.0
   * @access public
   * @return bool True if in block editor
   */
  public function is_block_editor(): bool
  {
    if (\function_exists("get_current_screen")) {
      $screen = \get_current_screen();
      return $screen && \method_exists($screen, "is_block_editor") && $screen->is_block_editor();
    }

    // Fallback for older WordPress versions
    return defined("REST_REQUEST") && \REST_REQUEST && !empty($_REQUEST["context"]) && $_REQUEST["context"] === "edit";
  }

  /**
   * Get block configuration for JavaScript
   *
   * Returns configuration data that can be passed to JavaScript
   * for enhanced block functionality.
   *
   * @since 1.0.0
   * @access public
   * @return array Configuration array
   */
  public function get_block_config(): array
  {
    return [
      "pluginUrl" => LEADGEN_APP_FORM_PLUGIN_URL,
      "version" => LEADGEN_APP_FORM_VERSION,
      "textDomain" => "leadgen-app-form",
      "hasGutenberg" => \function_exists("register_block_type"),
      "isBlockEditor" => $this->is_block_editor()
    ];
  }
}
