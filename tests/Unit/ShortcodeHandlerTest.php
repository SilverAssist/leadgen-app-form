<?php
/**
 * Tests for the ShortcodeHandler component.
 *
 * @package LeadGenAppForm
 * @since 1.3.0
 */

namespace LeadGenAppForm\Tests\Unit;

use LeadGenAppForm\ShortcodeHandler;
use WP_UnitTestCase;

/**
 * Test case for ShortcodeHandler, using the real WordPress test environment.
 *
 * @since 1.3.0
 */
class ShortcodeHandlerTest extends WP_UnitTestCase
{
    /**
     * Test singleton instance creation.
     *
     * @return void
     */
    public function test_instance_returns_singleton(): void
    {
        $instance1 = ShortcodeHandler::instance();
        $instance2 = ShortcodeHandler::instance();

        $this->assertInstanceOf(ShortcodeHandler::class, $instance1);
        $this->assertSame($instance1, $instance2);
    }

    /**
     * Test that ShortcodeHandler implements the shared LoadableInterface.
     *
     * @return void
     */
    public function test_implements_loadable_interface(): void
    {
        $this->assertInstanceOf(
            \SilverAssist\PluginKernel\Interfaces\LoadableInterface::class,
            ShortcodeHandler::instance()
        );
    }

    /**
     * Test get_priority returns the Services-tier value.
     *
     * @return void
     */
    public function test_get_priority_returns_expected_value(): void
    {
        $this->assertSame(20, ShortcodeHandler::instance()->get_priority());
    }

    /**
     * Test should_load always returns true (no gating dependency).
     *
     * @return void
     */
    public function test_should_load_returns_true(): void
    {
        $this->assertTrue(ShortcodeHandler::instance()->should_load());
    }

    /**
     * Test init() registers the shortcode and enqueue hook.
     *
     * @return void
     */
    public function test_init_registers_shortcode_and_enqueue_hook(): void
    {
        $instance = ShortcodeHandler::instance();
        $instance->init();

        $this->assertTrue(shortcode_exists('leadgen_form'));
        $this->assertGreaterThan(0, has_action('wp_enqueue_scripts', [$instance, 'enqueue_scripts']));
    }

    /**
     * Test render_shortcode returns an error message when neither ID is provided.
     *
     * @return void
     */
    public function test_render_shortcode_errors_without_any_id(): void
    {
        $output = ShortcodeHandler::instance()->render_shortcode([]);

        $this->assertStringContainsString('leadgen-form-error', $output);
        $this->assertStringContainsString('desktop-id or mobile-id', $output);
    }

    /**
     * Test render_shortcode renders the form container when a desktop ID is provided.
     *
     * @return void
     */
    public function test_render_shortcode_renders_container_with_desktop_id(): void
    {
        $output = ShortcodeHandler::instance()->render_shortcode(['desktop-id' => 'my-desktop-form']);

        $this->assertStringContainsString('leadgen-form-container', $output);
        $this->assertStringContainsString('data-desktop-id="my-desktop-form"', $output);
    }
}
