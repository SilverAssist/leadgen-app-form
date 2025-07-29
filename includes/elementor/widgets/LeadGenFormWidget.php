<?php
/**
 * LeadGen Form Elementor Widget
 *
 * Elementor widget for displaying LeadGen forms with desktop and mobile IDs.
 * Integrates with the existing shortcode functionality.
 *
 * @package LeadGenAppForm\Elementor\Widgets
 * @version 1.0.3
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
class LeadGenFormWidget extends Widget_Base
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
    return \esc_html__("LeadGen Form", "leadgen-app-form");
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
   * @return array Widget keywords
   */
  public function get_keywords(): array
  {
    return ["leadgen", "form", "contact", "lead", "generation"];
  }

  /**
   * Register widget controls
   *
   * Adds input fields to allow user to set widget's customization options.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function register_controls(): void
  {
    // Content Tab
    $this->start_controls_section(
      "content_section",
      [
        "label" => \esc_html__("Form Settings", "leadgen-app-form"),
        "tab" => Controls_Manager::TAB_CONTENT,
      ]
    );

    // Desktop Form ID
    $this->add_control(
      "desktop_id",
      [
        "label" => \esc_html__("Desktop Form ID", "leadgen-app-form"),
        "type" => Controls_Manager::TEXT,
        "placeholder" => \esc_html__("Enter desktop form ID", "leadgen-app-form"),
        "description" => \esc_html__("Form ID to use for desktop devices", "leadgen-app-form"),
      ]
    );

    // Mobile Form ID
    $this->add_control(
      "mobile_id",
      [
        "label" => \esc_html__("Mobile Form ID", "leadgen-app-form"),
        "type" => Controls_Manager::TEXT,
        "placeholder" => \esc_html__("Enter mobile form ID", "leadgen-app-form"),
        "description" => \esc_html__("Form ID to use for mobile devices", "leadgen-app-form"),
      ]
    );

    $this->end_controls_section();

    // Height Controls Section (New in v1.0.3)
    $this->start_controls_section(
      "height_section",
      [
        "label" => \esc_html__("Height Settings", "leadgen-app-form"),
        "tab" => Controls_Manager::TAB_CONTENT,
      ]
    );

    // Desktop Height Control
    $this->add_control(
      "desktop_height_enable",
      [
        "label" => \esc_html__("Custom Desktop Height", "leadgen-app-form"),
        "type" => Controls_Manager::SWITCHER,
        "label_on" => \esc_html__("Yes", "leadgen-app-form"),
        "label_off" => \esc_html__("No", "leadgen-app-form"),
        "return_value" => "yes",
        "default" => "",
        "description" => \esc_html__("Enable custom height for desktop devices", "leadgen-app-form"),
      ]
    );

    $this->add_control(
      "desktop_height_value",
      [
        "label" => \esc_html__("Desktop Height Value", "leadgen-app-form"),
        "type" => Controls_Manager::SLIDER,
        "size_units" => ["px", "vh", "%", "em", "rem"],
        "range" => [
          "px" => [
            "min" => 200,
            "max" => 1200,
            "step" => 10,
          ],
          "vh" => [
            "min" => 20,
            "max" => 100,
            "step" => 1,
          ],
          "%" => [
            "min" => 20,
            "max" => 100,
            "step" => 1,
          ],
          "em" => [
            "min" => 10,
            "max" => 50,
            "step" => 0.5,
          ],
          "rem" => [
            "min" => 10,
            "max" => 50,
            "step" => 0.5,
          ],
        ],
        "default" => [
          "unit" => "px",
          "size" => 500,
        ],
        "condition" => [
          "desktop_height_enable" => "yes",
        ],
        "description" => \esc_html__("Set the placeholder height for desktop devices", "leadgen-app-form"),
      ]
    );

    // Mobile Height Control
    $this->add_control(
      "mobile_height_enable",
      [
        "label" => \esc_html__("Custom Mobile Height", "leadgen-app-form"),
        "type" => Controls_Manager::SWITCHER,
        "label_on" => \esc_html__("Yes", "leadgen-app-form"),
        "label_off" => \esc_html__("No", "leadgen-app-form"),
        "return_value" => "yes",
        "default" => "",
        "description" => \esc_html__("Enable custom height for mobile devices", "leadgen-app-form"),
      ]
    );

    $this->add_control(
      "mobile_height_value",
      [
        "label" => \esc_html__("Mobile Height Value", "leadgen-app-form"),
        "type" => Controls_Manager::SLIDER,
        "size_units" => ["px", "vh", "%", "em", "rem"],
        "range" => [
          "px" => [
            "min" => 200,
            "max" => 800,
            "step" => 10,
          ],
          "vh" => [
            "min" => 20,
            "max" => 100,
            "step" => 1,
          ],
          "%" => [
            "min" => 20,
            "max" => 100,
            "step" => 1,
          ],
          "em" => [
            "min" => 10,
            "max" => 40,
            "step" => 0.5,
          ],
          "rem" => [
            "min" => 10,
            "max" => 40,
            "step" => 0.5,
          ],
        ],
        "default" => [
          "unit" => "px",
          "size" => 400,
        ],
        "condition" => [
          "mobile_height_enable" => "yes",
        ],
        "description" => \esc_html__("Set the placeholder height for mobile devices", "leadgen-app-form"),
      ]
    );

    $this->end_controls_section();

    // Help Section
    $this->start_controls_section(
      "help_section",
      [
        "label" => \esc_html__("Help & Usage", "leadgen-app-form"),
        "tab" => Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      "help_text",
      [
        "type" => Controls_Manager::RAW_HTML,
        "raw" => "<div style=\"padding: 15px; background: #f8f9fa; border-radius: 5px; margin: 10px 0;\">
                    <h4 style=\"margin-top: 0;\">" . \esc_html__("Usage Instructions", "leadgen-app-form") . "</h4>
                    <p><strong>" . \esc_html__("Required:", "leadgen-app-form") . "</strong> " . \esc_html__("At least one Form ID (Desktop or Mobile) must be provided.", "leadgen-app-form") . "</p>
                    <p><strong>" . \esc_html__("Height Controls:", "leadgen-app-form") . "</strong> " . \esc_html__("Use custom heights to control the placeholder size while forms load.", "leadgen-app-form") . "</p>
                    <p><strong>" . \esc_html__("Responsive:", "leadgen-app-form") . "</strong> " . \esc_html__("The widget automatically detects device type and loads the appropriate form.", "leadgen-app-form") . "</p>
                  </div>",
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Render the widget output on the frontend
   *
   * @since 1.0.0
   * @access protected
   */
  protected function render(): void
  {
    $settings = $this->get_settings_for_display();

    // Validate that at least one ID is present
    if (empty($settings["desktop_id"]) && empty($settings["mobile_id"])) {
      if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
        echo "<div style=\"padding: 20px; text-align: center; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;\">";
        echo \esc_html__("⚠️ Please configure at least one Form ID (Desktop or Mobile) in the widget settings.", "leadgen-app-form");
        echo "</div>";
      }
      return;
    }

    // Build shortcode attributes
    $shortcode_atts = [];

    if (!empty($settings["desktop_id"])) {
      $shortcode_atts["desktop-id"] = \sanitize_text_field($settings["desktop_id"]);
    }

    if (!empty($settings["mobile_id"])) {
      $shortcode_atts["mobile-id"] = \sanitize_text_field($settings["mobile_id"]);
    }

    // Handle height settings (New in v1.0.3)
    if (!empty($settings["desktop_height_enable"]) && $settings["desktop_height_enable"] === "yes") {
      $desktop_height = $settings["desktop_height_value"];
      if (!empty($desktop_height["size"]) && !empty($desktop_height["unit"])) {
        $shortcode_atts["desktop-height"] = $desktop_height["size"] . $desktop_height["unit"];
      }
    }

    if (!empty($settings["mobile_height_enable"]) && $settings["mobile_height_enable"] === "yes") {
      $mobile_height = $settings["mobile_height_value"];
      if (!empty($mobile_height["size"]) && !empty($mobile_height["unit"])) {
        $shortcode_atts["mobile-height"] = $mobile_height["size"] . $mobile_height["unit"];
      }
    }

    // Convert attributes array to shortcode string
    $shortcode_parts = [];
    foreach ($shortcode_atts as $key => $value) {
      $shortcode_parts[] = $key . "=\"" . \esc_attr($value) . "\"";
    }

    $shortcode = "[leadgen_form " . implode(" ", $shortcode_parts) . "]";

    // Render the shortcode
    echo \do_shortcode($shortcode);
  }

  /**
   * Render the widget output in the editor
   *
   * @since 1.0.0
   * @access protected
   */
  protected function content_template(): void
  {
    ?>
    <#
    var desktopId = settings.desktop_id || '';
    var mobileId = settings.mobile_id || '';
    
    if (!desktopId && !mobileId) {
        #>
        <div style="padding: 20px; text-align: center; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;">
            <?php echo \esc_html__("⚠️ Please configure at least one Form ID (Desktop or Mobile) in the widget settings.", "leadgen-app-form"); ?>
        </div>
        <#
        return;
    }
    
    var shortcodeAtts = [];
    
    if (desktopId) {
        shortcodeAtts.push('desktop-id="' + desktopId + '"');
    }
    
    if (mobileId) {
        shortcodeAtts.push('mobile-id="' + mobileId + '"');
    }
    
    // Handle height settings
    if (settings.desktop_height_enable === 'yes' && settings.desktop_height_value) {
        var desktopHeight = settings.desktop_height_value.size + settings.desktop_height_value.unit;
        shortcodeAtts.push('desktop-height="' + desktopHeight + '"');
    }
    
    if (settings.mobile_height_enable === 'yes' && settings.mobile_height_value) {
        var mobileHeight = settings.mobile_height_value.size + settings.mobile_height_value.unit;
        shortcodeAtts.push('mobile-height="' + mobileHeight + '"');
    }
    
    var shortcode = '[leadgen_form ' + shortcodeAtts.join(' ') + ']';
    #>
    <div style="padding: 20px; text-align: center; background: #e7f3ff; border: 2px dashed #0073aa; border-radius: 5px;">
        <h3 style="margin-top: 0; color: #0073aa;">📝 LeadGen Form Widget</h3>
        <p style="font-family: monospace; background: white; padding: 10px; border-radius: 3px; margin: 10px 0;">
            {{{ shortcode }}}
        </p>
        <p style="color: #666; font-size: 12px; margin-bottom: 0;">
            <?php echo \esc_html__("This preview shows the shortcode that will be rendered. The actual form will appear on the frontend.", "leadgen-app-form"); ?>
        </p>
    </div>
    <?php
  }
}
