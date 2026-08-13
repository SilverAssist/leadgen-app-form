<?php
/**
 * Tests for the Elementor WidgetsLoader component.
 *
 * @package LeadGenAppForm
 * @since 1.3.0
 */

namespace LeadGenAppForm\Tests\Unit;

use LeadGenAppForm\Elementor\WidgetsLoader;
use WP_UnitTestCase;

/**
 * Test case for WidgetsLoader, using the real WordPress test environment.
 *
 * @since 1.3.0
 */
class WidgetsLoaderTest extends WP_UnitTestCase
{
    /**
     * Test singleton instance creation.
     *
     * @return void
     */
    public function test_instance_returns_singleton(): void
    {
        $instance1 = WidgetsLoader::instance();
        $instance2 = WidgetsLoader::instance();

        $this->assertInstanceOf(WidgetsLoader::class, $instance1);
        $this->assertSame($instance1, $instance2);
    }

    /**
     * Test the deprecated get_instance() alias forwards to instance().
     *
     * @return void
     */
    public function test_deprecated_get_instance_forwards_to_instance(): void
    {
        $this->assertSame(WidgetsLoader::instance(), WidgetsLoader::get_instance());
    }

    /**
     * Test that WidgetsLoader implements the shared LoadableInterface.
     *
     * @return void
     */
    public function test_implements_loadable_interface(): void
    {
        $this->assertInstanceOf(
            \SilverAssist\PluginKernel\Interfaces\LoadableInterface::class,
            WidgetsLoader::instance()
        );
    }

    /**
     * Test get_priority returns the Admin-tier value.
     *
     * @return void
     */
    public function test_get_priority_returns_expected_value(): void
    {
        $this->assertSame(30, WidgetsLoader::instance()->get_priority());
    }

    /**
     * Test should_load tracks did_action('elementor/loaded').
     *
     * did_action() counts are cumulative and can't be "un-fired", so this
     * only exercises the false-to-true transition, not a reset back to
     * false — which matches the real lifecycle (Elementor, once loaded,
     * stays loaded for the rest of the request).
     *
     * @return void
     */
    public function test_should_load_tracks_elementor_loaded_action(): void
    {
        $this->assertFalse(did_action('elementor/loaded') > 0, 'Precondition: Elementor has not fired its loaded action yet');
        $this->assertFalse(WidgetsLoader::instance()->should_load());

        do_action('elementor/loaded');

        $this->assertTrue(WidgetsLoader::instance()->should_load());
    }

    /**
     * Test get_widget_list returns the known widget mapping.
     *
     * @return void
     */
    public function test_get_widget_list_returns_leadgen_form_widget(): void
    {
        $this->assertSame(['leadgen-form' => 'LeadGenFormWidget'], WidgetsLoader::get_widget_list());
    }

    /**
     * Test get_elementor_instance returns null when Elementor isn't loaded.
     *
     * The bare WordPress test environment doesn't have Elementor installed.
     *
     * @return void
     */
    public function test_get_elementor_instance_returns_null_without_elementor(): void
    {
        $this->assertFalse(class_exists('\Elementor\Plugin'), 'Precondition: Elementor is not installed in this test environment');
        $this->assertNull(WidgetsLoader::instance()->get_elementor_instance());
    }
}
