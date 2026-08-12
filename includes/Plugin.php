<?php
/**
 * Main Plugin Class
 *
 * Handles plugin initialization and coordinates between components.
 *
 * @package LeadGenAppForm
 * @since 1.3.0
 * @version 1.3.0
 * @author Silver Assist
 */

namespace LeadGenAppForm;

use LeadGenAppForm\Block\LeadGenFormBlock;
use LeadGenAppForm\Elementor\WidgetsLoader;
use SilverAssist\PluginKernel\AbstractPlugin;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Plugin
 *
 * Singleton access (instance()) and the priority-ordered component loading
 * loop are inherited from AbstractPlugin (silverassist/wp-plugin-kernel) —
 * this class only declares which components to load (get_components()) and
 * the plugin-specific setup that runs alongside them (init_hooks()).
 *
 * Extracted from the plugin's former monolithic LeadGen_App_Form class,
 * which lived directly in the main plugin file.
 *
 * @since 1.3.0
 */
class Plugin extends AbstractPlugin {

	/**
	 * Updater instance
	 *
	 * @var LeadGenAppFormUpdater|null
	 */
	private ?LeadGenAppFormUpdater $updater = null;

	/**
	 * List the component classes this plugin loads
	 *
	 * Loading order is determined by each component's get_priority(), not
	 * by the order they're listed here.
	 *
	 * @since 1.3.0
	 * @return array<class-string>
	 */
	protected function get_components(): array {
		return array(
			ShortcodeHandler::class,
			LeadGenFormBlock::class,
			WidgetsLoader::class,
			LeadGenAppFormAdmin::class,
		);
	}

	/**
	 * Plugin-level setup that isn't itself a LoadableInterface component
	 *
	 * Runs after all components have loaded.
	 *
	 * @since 1.3.0
	 * @return void
	 */
	protected function init_hooks(): void {
		$this->load_textdomain();
		$this->init_updater();
	}

	/**
	 * Load plugin textdomain for translations
	 *
	 * @since 1.3.0
	 * @return void
	 */
	private function load_textdomain(): void {
		\load_plugin_textdomain(
			'leadgen-app-form',
			false,
			\dirname( LEADGEN_APP_FORM_PLUGIN_BASENAME ) . '/languages'
		);
	}

	/**
	 * Initialize GitHub updater
	 *
	 * Sets up automatic updates from GitHub releases. Admin-only, matching
	 * LeadGenAppFormAdmin's should_load() gate — the updater's only
	 * consumer is that admin page's "Check Updates" action.
	 *
	 * @since 1.3.0
	 * @return void
	 */
	private function init_updater(): void {
		if ( ! \is_admin() ) {
			return;
		}

		if ( ! \class_exists( LeadGenAppFormUpdater::class ) ) {
			return;
		}

		// Public repository - no authentication required.
		$this->updater = new LeadGenAppFormUpdater( LEADGEN_APP_FORM_FILE, 'SilverAssist/leadgen-app-form' );
	}

	/**
	 * Get Updater instance
	 *
	 * @since 1.3.0
	 * @return LeadGenAppFormUpdater|null
	 */
	public function get_updater(): ?LeadGenAppFormUpdater {
		return $this->updater;
	}
}
