<?php
/**
 * Tests for the LeadGenFormBlock component.
 *
 * @package LeadGenAppForm
 * @since 1.3.0
 */

namespace LeadGenAppForm\Tests\Unit;

use LeadGenAppForm\Block\LeadGenFormBlock;
use LeadGenAppForm\ShortcodeHandler;
use WP_UnitTestCase;

/**
 * Test case for LeadGenFormBlock, using the real WordPress test environment.
 *
 * @since 1.3.0
 */
class LeadGenFormBlockTest extends WP_UnitTestCase
{
    /**
     * Test singleton instance creation.
     *
     * @return void
     */
    public function test_instance_returns_singleton(): void
    {
        $instance1 = LeadGenFormBlock::instance();
        $instance2 = LeadGenFormBlock::instance();

        $this->assertInstanceOf(LeadGenFormBlock::class, $instance1);
        $this->assertSame($instance1, $instance2);
    }

    /**
     * Test the deprecated get_instance() alias forwards to instance().
     *
     * @return void
     */
    public function test_deprecated_get_instance_forwards_to_instance(): void
    {
        $this->assertSame(LeadGenFormBlock::instance(), LeadGenFormBlock::get_instance());
    }

    /**
     * Test that LeadGenFormBlock implements the shared LoadableInterface.
     *
     * @return void
     */
    public function test_implements_loadable_interface(): void
    {
        $this->assertInstanceOf(
            \SilverAssist\PluginKernel\Interfaces\LoadableInterface::class,
            LeadGenFormBlock::instance()
        );
    }

    /**
     * Test get_priority returns the Services-tier value.
     *
     * @return void
     */
    public function test_get_priority_returns_expected_value(): void
    {
        $this->assertSame(20, LeadGenFormBlock::instance()->get_priority());
    }

    /**
     * Test should_load always returns true (no gating dependency).
     *
     * @return void
     */
    public function test_should_load_returns_true(): void
    {
        $this->assertTrue(LeadGenFormBlock::instance()->should_load());
    }

    /**
     * Test init() registers the block registration and editor asset hooks.
     *
     * @return void
     */
    public function test_init_registers_hooks(): void
    {
        $instance = LeadGenFormBlock::instance();
        $instance->init();

        $this->assertGreaterThan(0, has_action('init', [$instance, 'register_block']));
        $this->assertGreaterThan(0, has_action('enqueue_block_editor_assets', [$instance, 'enqueue_block_editor_assets']));
    }

    /**
     * Test render_block returns an error message when neither ID is provided.
     *
     * @return void
     */
    public function test_render_block_errors_without_any_id(): void
    {
        $output = LeadGenFormBlock::instance()->render_block([]);

        $this->assertStringContainsString('leadgen-form-error', $output);
    }

    /**
     * Test render_block renders the shortcode-backed container with a mobile ID.
     *
     * @return void
     */
    public function test_render_block_renders_container_with_mobile_id(): void
    {
        // render_block() delegates to do_shortcode(), which needs the
        // shortcode registered regardless of ShortcodeHandlerTest's run order.
        ShortcodeHandler::instance()->init();

        $output = LeadGenFormBlock::instance()->render_block(['mobileId' => 'my-mobile-form']);

        $this->assertStringContainsString('data-mobile-id="my-mobile-form"', $output);
    }

    /**
     * Test get_block_config returns the expected block name.
     *
     * @return void
     */
    public function test_get_block_config_returns_expected_name(): void
    {
        $config = LeadGenFormBlock::instance()->get_block_config();

        $this->assertSame('leadgen-app-form/leadgen-form', $config['name']);
    }
}
