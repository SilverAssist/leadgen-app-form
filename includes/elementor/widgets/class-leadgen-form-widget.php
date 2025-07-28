<?php
/**
 * LeadGen Form Elementor Widget
 *
 * Elementor widget for displaying LeadGen forms with desktop and mobile IDs.
 * Integrates with the existing shortcode functionality.
 *
 * @package LeadGenAppForm\Elementor\Widgets
 * @version 1.0.1
 * @since 1.0.0
 * @author Silver Assist
 */

namespace LeadGenAppForm\Elementor\Widgets;

defined("ABSPATH") or exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

/**
 * LeadGen Form Widget for Elementor
 *
 * Provides Elementor integration for the LeadGen App Form Plugin shortcode,
 * allowing users to configure desktop-id and mobile-id parameters
 * through the Elementor visual editor interface.
 *
 * @since 1.0.0
 */
class LeadGen_Form_Widget extends Widget_Base
{
  /**
   * Get widget name
   *
   * @since 1.0.0
   * @access public
   * @return string Widget name
   */
  public function get_name(): string
  {
    return "leadgen-form";
  }

  /**
   * Get widget title
   *
   * @since 1.0.0
   * @access public
   * @return string Widget title
   */
  public function get_title(): string
  {
    return __("LeadGen Form", "leadgen-app-form");
  }

  /**
   * Get widget icon
   *
   * @since 1.0.0
   * @access public
   * @return string Widget icon
   */
  public function get_icon(): string
  {
    return "eicon-form-horizontal";
  }

  /**
   * Get widget categories
   *
   * @since 1.0.0
   * @access public
   * @return array Widget categories
   */
  public function get_categories(): array
  {
    return ["leadgen-forms"];
  }

  /**
   * Get widget keywords
   *
   * @since 1.0.0
   * @access public
   * @return array Widget keywords for search
   */
  public function get_keywords(): array
  {
    return ["leadgen", "form", "lead", "generation", "mobile", "desktop"];
  }

  /**
   * Get widget style dependencies
   *
   * @since 1.0.0
   * @access public
   * @return array Widget style dependencies
   */
  public function get_style_depends(): array
  {
    return ["leadgen-app-form-css"];
  }

  /**
   * Get widget script dependencies
   *
   * @since 1.0.0
   * @access public
   * @return array Widget script dependencies
   */
  public function get_script_depends(): array
  {
    return ["leadgen-app-form-js"];
  }

  /**
   * Register widget controls
   *
   * Adds controls for desktop-id and mobile-id parameters,
   * matching the shortcode attributes functionality.
   *
   * @since 1.0.0
   * @access protected
   * @return void
   */
  protected function register_controls(): void
  {
    $this->register_content_controls();
    $this->register_style_controls();
  }

  /**
   * Register content controls
   *
   * @since 1.0.0
   * @access protected
   * @return void
   */
  protected function register_content_controls(): void
  {
    $this->start_controls_section(
      "section_form_settings",
      [
        "label" => __("Form Settings", "leadgen-app-form"),
        "tab" => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      "desktop_id",
      [
        "label" => __("Desktop Form ID", "leadgen-app-form"),
        "type" => Controls_Manager::TEXT,
        "placeholder" => __("Enter desktop form ID", "leadgen-app-form"),
        "description" => __("Form ID to display on desktop devices", "leadgen-app-form"),
        "label_block" => true,
      ]
    );

    $this->add_control(
      "mobile_id",
      [
        "label" => __("Mobile Form ID", "leadgen-app-form"),
        "type" => Controls_Manager::TEXT,
        "placeholder" => __("Enter mobile form ID", "leadgen-app-form"),
        "description" => __("Form ID to display on mobile devices", "leadgen-app-form"),
        "label_block" => true,
      ]
    );

    $this->add_control(
      "form_ids_note",
      [
        "type" => Controls_Manager::RAW_HTML,
        "raw" => "<div style=\"background: #f1f1f1; padding: 10px; border-radius: 4px; margin-top: 10px;\">" .
          "<strong>" . __("Note:", "leadgen-app-form") . "</strong><br>" .
          __("At least one Form ID (Desktop or Mobile) is required. If only one ID is provided, it will be used for both device types.", "leadgen-app-form") .
          "</div>",
        "content_classes" => "elementor-control-field-description",
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Register style controls
   *
   * @since 1.0.0
   * @access protected
   * @return void
   */
  protected function register_style_controls(): void
  {
    $this->start_controls_section(
      "section_form_style",
      [
        "label" => __("Form Style", "leadgen-app-form"),
        "tab" => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      "form_alignment",
      [
        "label" => __("Alignment", "leadgen-app-form"),
        "type" => Controls_Manager::CHOOSE,
        "options" => [
          "left" => [
            "title" => __("Left", "leadgen-app-form"),
            "icon" => "eicon-text-align-left",
          ],
          "center" => [
            "title" => __("Center", "leadgen-app-form"),
            "icon" => "eicon-text-align-center",
          ],
          "right" => [
            "title" => __("Right", "leadgen-app-form"),
            "icon" => "eicon-text-align-right",
          ],
        ],
        "default" => "center",
        "selectors" => [
          "{{WRAPPER}} .leadgen-form-container" => "text-align: {{VALUE}};",
        ],
      ]
    );

    $this->add_responsive_control(
      "form_width",
      [
        "label" => __("Width", "leadgen-app-form"),
        "type" => Controls_Manager::SLIDER,
        "size_units" => ["px", "%", "vw"],
        "range" => [
          "px" => [
            "min" => 100,
            "max" => 1000,
            "step" => 10,
          ],
          "%" => [
            "min" => 10,
            "max" => 100,
            "step" => 1,
          ],
        ],
        "default" => [
          "unit" => "%",
          "size" => 100,
        ],
        "selectors" => [
          "{{WRAPPER}} .leadgen-form-container" => "max-width: {{SIZE}}{{UNIT}};",
        ],
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Render widget output on the frontend
   *
   * Uses the existing shortcode functionality to maintain consistency
   * across different implementation methods (shortcode, Gutenberg, Elementor).
   *
   * @since 1.0.0
   * @access protected
   * @return void
   */
  protected function render(): void
  {
    $settings = $this->get_settings_for_display();

    // Get the form IDs from widget settings
    $desktop_id = !empty($settings["desktop_id"]) ? \sanitize_text_field($settings["desktop_id"]) : "";
    $mobile_id = !empty($settings["mobile_id"]) ? \sanitize_text_field($settings["mobile_id"]) : "";

    // Validate that at least one ID is present
    if (empty($desktop_id) && empty($mobile_id)) {
      if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        // Show error message only in Elementor editor
        echo "<div class=\"leadgen-form-error elementor-alert elementor-alert-warning\">" .
          "<span class=\"elementor-alert-title\">" . esc_html__("LeadGen Form Widget", "leadgen-app-form") . "</span>" .
          "<span class=\"elementor-alert-description\">" . esc_html__("Please configure at least one Form ID (Desktop or Mobile) in the widget settings.", "leadgen-app-form") . "</span>" .
          "</div>";
      }
      return;
    }

    // Use the existing shortcode function to render the form
    $plugin_instance = \LeadGenAppForm\LeadGen_App_Form::get_instance();

    // Prepare shortcode attributes
    $shortcode_atts = [];
    if (!empty($desktop_id)) {
      $shortcode_atts["desktop-id"] = $desktop_id;
    }
    if (!empty($mobile_id)) {
      $shortcode_atts["mobile-id"] = $mobile_id;
    }

    // Render using the shortcode method for consistency
    echo $plugin_instance->render_shortcode($shortcode_atts);
  }

  /**
   * Render widget content template for live preview
   *
   * Used by Elementor editor for live preview functionality.
   * Shows a placeholder representation of the form.
   *
   * @since 1.0.0
   * @access protected
   * @return void
   */
  protected function content_template(): void
  {
    ?>
    <# var desktopId=settings.desktop_id || "" ; var mobileId=settings.mobile_id || "" ; if (!desktopId && !mobileId) { #>
      <div class="leadgen-form-error elementor-alert elementor-alert-warning">
        <span class="elementor-alert-title"><?php echo esc_js(__("LeadGen Form Widget", "leadgen-app-form")); ?></span>
        <span
          class="elementor-alert-description"><?php echo esc_js(__("Please configure at least one Form ID (Desktop or Mobile) in the widget settings.", "leadgen-app-form")); ?></span>
      </div>
      <# } else { #>
        <div class="leadgen-form-container elementor-leadgen-preview">
          <div class="leadgen-form-wrapper">
            <div class="leadgen-form-placeholder">
              <div class="leadgen-pulse-animation"></div>
            </div>
            <div class="leadgen-form-preview-info">
              <h4><?php echo esc_js(__("LeadGen Form Preview", "leadgen-app-form")); ?></h4>
              <# if (desktopId) { #>
                <p><strong><?php echo esc_js(__("Desktop ID:", "leadgen-app-form")); ?></strong> {{desktopId}}</p>
                <# } #>
                  <# if (mobileId) { #>
                    <p><strong><?php echo esc_js(__("Mobile ID:", "leadgen-app-form")); ?></strong> {{mobileId}}</p>
                    <# } #>
                      <p>
                        <em><?php echo esc_js(__("The actual form will be displayed on the frontend.", "leadgen-app-form")); ?></em>
                      </p>
            </div>
          </div>
        </div>
        <# } #>
          <?php
  }
}
