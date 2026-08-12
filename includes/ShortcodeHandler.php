<?php
/**
 * LeadGen Form Shortcode Handler
 *
 * Registers the [leadgen_form] shortcode and conditionally enqueues the
 * plugin's frontend assets when the shortcode or an Elementor LeadGen
 * widget is present on the current page.
 *
 * @package LeadGenAppForm
 * @version 1.3.0
 * @since 1.3.0
 * @author Silver Assist
 */

namespace LeadGenAppForm;

use SilverAssist\PluginKernel\Interfaces\LoadableInterface;
use WP_Post;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ShortcodeHandler
 *
 * Extracted from the plugin's former monolithic LeadGen_App_Form class as
 * part of adopting silverassist/wp-plugin-kernel's LoadableInterface
 * bootstrap pattern.
 *
 * @since 1.3.0
 */
class ShortcodeHandler implements LoadableInterface {

	/**
	 * Single instance of the shortcode handler
	 *
	 * @since 1.3.0
	 * @var ShortcodeHandler|null
	 * @access private
	 * @static
	 */
	private static ?ShortcodeHandler $instance = null;

	/**
	 * Get the single instance of the shortcode handler
	 *
	 * @since 1.3.0
	 * @access public
	 * @static
	 * @return ShortcodeHandler
	 */
	public static function instance(): ShortcodeHandler {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Private constructor to prevent direct instantiation
	 *
	 * @since 1.3.0
	 * @access private
	 */
	private function __construct() {
	}

	/**
	 * Initialize the component
	 *
	 * @since 1.3.0
	 * @return void
	 */
	public function init(): void {
		\add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		\add_shortcode( 'leadgen_form', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Get the component loading priority
	 *
	 * @since 1.3.0
	 * @return int
	 */
	public function get_priority(): int {
		return 20;
	}

	/**
	 * Determine if the component should be loaded
	 *
	 * @since 1.3.0
	 * @return bool
	 */
	public function should_load(): bool {
		return true;
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
	public function enqueue_scripts(): void {
		// Register CSS.
		wp_register_style(
			'leadgen-app-form-css',
			LEADGEN_APP_FORM_PLUGIN_URL . 'assets/css/leadgen-app-form.css',
			array(),
			LEADGEN_APP_FORM_VERSION
		);

		// Register JavaScript.
		wp_register_script(
			'leadgen-app-form-js',
			LEADGEN_APP_FORM_PLUGIN_URL . 'assets/js/leadgen-app-form.js',
			array( 'jquery' ),
			LEADGEN_APP_FORM_VERSION,
			true
		);

		global $post;
		$should_load_scripts = false;
		$shortcode_instances = array();

		// Check if shortcode is present in post content.
		if ( is_a( $post, WP_Post::class ) && has_shortcode( $post->post_content, 'leadgen_form' ) ) {
			$should_load_scripts = true;
			$shortcode_instances = $this->extract_shortcode_instances( $post->post_content );
		}

		// Check if Elementor widgets are present.
		if ( ! $should_load_scripts && $this->has_elementor_widgets() ) {
			$should_load_scripts = true;
			// For Elementor widgets, we'll let JavaScript handle the initialization
			// since the widget data is available in the DOM.
		}

		if ( $should_load_scripts ) {
			wp_enqueue_style( 'leadgen-app-form-css' );
			wp_enqueue_script( 'leadgen-app-form-js' );

			// Localize script with global settings.
			wp_localize_script(
				'leadgen-app-form-js',
				'leadGenAppSettings',
				array(
					'ajax_url'      => admin_url( 'admin-ajax.php' ),
					'nonce'         => wp_create_nonce( 'leadgen_form_nonce' ),
					'instances'     => $shortcode_instances,
					'base_form_url' => 'https://forms.leadgenapp.io/js/lf.min.js/',
				)
			);
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
	public function render_shortcode( $atts ): string {
		// Default attributes.
		$atts = shortcode_atts(
			array(
				'desktop-id'     => '',
				'mobile-id'      => '',
				'desktop-height' => '',
				'mobile-height'  => '',
			),
			$atts,
			'leadgen_form'
		);

		// Validate that at least one ID is present.
		if ( empty( $atts['desktop-id'] ) && empty( $atts['mobile-id'] ) ) {
			return '<div class="leadgen-form-error">' .
			esc_html__( 'Error: At least one of the desktop-id or mobile-id parameters is required', 'leadgen-app-form' ) .
			'</div>';
		}

		// Sanitize attributes using null coalescing.
		$desktop_id     = \sanitize_text_field( $atts['desktop-id'] ?? '' );
		$mobile_id      = \sanitize_text_field( $atts['mobile-id'] ?? '' );
		$desktop_height = \sanitize_text_field( $atts['desktop-height'] ?? '' );
		$mobile_height  = \sanitize_text_field( $atts['mobile-height'] ?? '' );

		// Detect if mobile device.
		$is_mobile = \wp_is_mobile();

		// Determine current ID using PHP 8 match expression for cleaner logic.
		$current_id = match ( true ) {
			$is_mobile && ! empty( $mobile_id ) => $mobile_id,
			! empty( $desktop_id ) => $desktop_id,
			! empty( $mobile_id ) => $mobile_id,
			default => ''
		};

		// Create unique ID for this shortcode instance.
		$instance_id = 'leadgen-form-' . \wp_generate_uuid4();

		// Generate form HTML using output buffering.
		ob_start();
		?>
	<div class="leadgen-form-container" id="<?php echo \esc_attr( $instance_id ); ?>"
		data-desktop-id="<?php echo \esc_attr( $desktop_id ); ?>" data-mobile-id="<?php echo \esc_attr( $mobile_id ); ?>"
		data-desktop-height="<?php echo \esc_attr( $desktop_height ); ?>" data-mobile-height="<?php echo \esc_attr( $mobile_height ); ?>"
		data-current-id="<?php echo \esc_attr( $current_id ); ?>" data-is-mobile="<?php echo $is_mobile ? '1' : '0'; ?>">

		<div class="leadgen-form-wrapper">
		<!-- Placeholder with pulse animation -->
		<div class="leadgen-form-placeholder">
			<div class="leadgen-pulse-animation"></div>
		</div>
		<!-- Form container -->
		<div id="leadgen-form-wrap-<?php echo \esc_attr( $current_id ); ?>" class="leadgen-form-content"
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
	 * @param string $content The post content to parse.
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
	private function extract_shortcode_instances( $content ): array {
		$instances = array();

		// Pattern to find leadgen_form shortcodes.
		$pattern = '/\[leadgen_form\s+([^\]]*)\]/';

		if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $index => $match ) {
				// Parse shortcode attributes.
				$atts = shortcode_parse_atts( $match[1] );

				if ( $atts ) {
					$desktop_id     = \sanitize_text_field( $atts['desktop-id'] ?? '' );
					$mobile_id      = \sanitize_text_field( $atts['mobile-id'] ?? '' );
					$desktop_height = \sanitize_text_field( $atts['desktop-height'] ?? '' );
					$mobile_height  = \sanitize_text_field( $atts['mobile-height'] ?? '' );

					// Only add if at least one ID is present.
					if ( ! empty( $desktop_id ) || ! empty( $mobile_id ) ) {
						$instances[] = array(
							'desktop_id'     => $desktop_id,
							'mobile_id'      => $mobile_id,
							'desktop_height' => $desktop_height,
							'mobile_height'  => $mobile_height,
							'index'          => $index,
						);
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
	private function has_elementor_widgets(): bool {
		// Early return if Elementor is not active.
		if ( ! class_exists( '\\Elementor\\Plugin' ) ) {
			return false;
		}

		global $post;
		if ( ! is_a( $post, WP_Post::class ) ) {
			return false;
		}

		// Check if this is an Elementor page.
		$elementor_data = get_post_meta( $post->ID, '_elementor_data', true );

		if ( empty( $elementor_data ) ) {
			return false;
		}

		// Parse Elementor data (it's stored as JSON).
		$elementor_data = json_decode( $elementor_data, true );

		if ( ! is_array( $elementor_data ) ) {
			return false;
		}

		// Recursively search for our widget in the Elementor data.
		return $this->search_elementor_data_for_widget( $elementor_data, 'leadgen-form' );
	}

	/**
	 * Recursively search Elementor data for specific widget type
	 *
	 * Searches through the nested Elementor data structure to find widgets
	 * of a specific type (widget name).
	 *
	 * @since 1.0.0
	 * @access private
	 * @param array  $data The Elementor data array to search.
	 * @param string $widget_name The widget name to search for.
	 * @return bool True if widget is found, false otherwise
	 */
	private function search_elementor_data_for_widget( array $data, string $widget_name ): bool {
		foreach ( $data as $element ) {
			if ( ! is_array( $element ) ) {
				continue;
			}

			// Check if this element is our widget.
			if ( isset( $element['widgetType'] ) && $element['widgetType'] === $widget_name ) {
				return true;
			}

			// Check elType for backwards compatibility.
			if (
				isset( $element['elType'] ) && $element['elType'] === 'widget' &&
				isset( $element['widgetType'] ) && $element['widgetType'] === $widget_name
			) {
				return true;
			}

			// Recursively search in elements (for sections, columns, etc.).
			if ( isset( $element['elements'] ) && is_array( $element['elements'] ) ) {
				if ( $this->search_elementor_data_for_widget( $element['elements'], $widget_name ) ) {
					return true;
				}
			}
		}

		return false;
	}
}
