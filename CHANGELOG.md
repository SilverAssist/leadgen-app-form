# Changelog

All notable changes to the LeadGen App Form Plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-07-21

### Added - Core Plugin Features
- **WordPress Shortcode System**: `[leadgen_form]` with desktop-id and mobile-id parameters
- **Gutenberg Block Integration**: Native block editor support with visual interface
- **Elementor Widget Integration**: Custom Elementor widget for page builder users
- **Block Editor UI**: Intuitive sidebar controls for form configuration
- **Elementor Visual Interface**: Drag-and-drop widget with native Elementor styling controls
- **Live Block Preview**: Real-time validation and configuration status display
- **Visual Form Indicators**: Clear feedback for configured vs unconfigured states
- **Responsive Form Logic**: Intelligent device detection and form switching
- **Server-Side Block Rendering**: SEO-friendly block output using existing shortcode system
- **Multiple Integration Methods**: Shortcode, Gutenberg block, and Elementor widget support
- Minimal user interaction pattern for enhanced performance
- CSS pulse animation placeholder during form loading
- External form script integration with LeadGen App API
- Conditional asset loading (only loads when shortcode is present)
- Dynamic form switching based on viewport changes
- Public JavaScript API for manual form control

### Added - Elementor Integration
- **LeadGen Form Widget**: Custom Elementor widget with native interface
- **Widget Category**: Organized under "LeadGen Forms" category in Elementor panel
- **Visual Configuration**: Form ID settings with validation and error prevention
- **Style Controls**: Alignment, width, and responsive settings in Elementor Style tab
- **Live Preview**: Configuration preview directly in Elementor editor
- **Error Handling**: Visual validation with user-friendly error messages
- **Consistent Rendering**: Uses same shortcode logic for reliable behavior
- **Conditional Loading**: Only loads when Elementor is active
- **Namespace Organization**: `LeadGenAppForm\Elementor\Widgets` namespace structure

### Added - Modern PHP 8.0+ Features
- **Namespace Organization**: Clean code structure with `LeadGenAppForm`, `LeadGenAppForm\Block`, and `LeadGenAppForm\Elementor\Widgets` namespaces
- **Match Expression**: Modern conditional logic replacing complex if/else chains (PHP 8.0+)
- **Array Spread in Arrays**: Efficient array building using spread operator `...` (PHP 8.0+)
- **Typed Properties**: `private static ?LeadGen_App_Form $instance = null` (PHP 7.4+)
- **Return Type Declarations**: All methods have explicit return types
  - `get_instance(): LeadGen_App_Form`
  - `render_shortcode($atts): string`
  - `extract_shortcode_instances($content): array`
  - `init_plugin(): void`, `enqueue_scripts(): void`, etc.
- **Null Coalescing Operator**: Clean default value handling with `??` operator
- **Void Return Types**: Explicit void returns for methods that don't return values
- **Global Function Calls**: Proper namespace handling with `\` prefix for WordPress functions

### Added - WordPress Integration & Best Practices
- **Complete PHPDoc and JSDoc Documentation**: Professional-grade code documentation
- **Modern PHP Syntax**: Short arrays `[]`, double quotes, const usage where applicable
- **Translation Support**: Full i18n support with text domain `leadgen-app-form`
- **Data Sanitization**: Comprehensive input sanitization with `sanitize_text_field()`
- **Error Handling**: Graceful error handling and user-friendly error messages
- **Hook-Based Architecture**: Clean separation using WordPress action/filter hooks
- **Activation/Deactivation Hooks**: Proper plugin lifecycle management with rewrite rule flushing
- **Conditional Asset Loading**: Smart loading of CSS/JS only when shortcode or block is present
- **Organized File Structure**: Maintainable folder structure following WordPress standards

### Added - Performance Optimizations & UX
- **Minimal User Interaction Pattern**: Forms load only on user engagement (focus, mousemove, scroll, touch)
- **Intelligent Script Management**: Prevents duplicate external script loading via Set() tracking
- **Conditional WordPress Asset Enqueuing**: Loads plugin assets only when needed
- **Responsive Form Switching**: Dynamic form switching based on viewport changes without page reload
- **CSS Pulse Animation Placeholder**: Smooth loading animations during form initialization
- **Optimized External API Integration**: Efficient loading from `https://forms.leadgenapp.io/js/lf.min.js/{id}`
- **Smart Device Detection**: Uses WordPress native `wp_is_mobile()` for reliable device detection
- **Performance Monitoring**: Built-in console logging for debugging and performance analysis

### Added - Architecture & Design Patterns
- **Singleton Pattern Implementation**: Memory-efficient single instance for main plugin class
- **Block Handler Singleton**: Separate singleton for Gutenberg block management
- **Server-Side Block Rendering**: Uses existing shortcode system for consistent output
- **Hook-Based Plugin Architecture**: Clean separation of concerns using WordPress hooks
- **Extensible Class Structure**: Organized includes/ folder ready for future expansion
- **Modern Block Registration**: Uses both `block.json` metadata and PHP registration
- **Type-Safe Development**: Leverages PHP 7.4+ typed properties for better code reliability

### Added - Developer Experience
- **Comprehensive API Documentation**: Complete PHPDoc for all classes and methods
- **JavaScript Public API**: Extended `window.LeadGenForm` API for advanced integrations
- **Block Development Standards**: Follows WordPress block development best practices
- **Translation Ready**: Full internationalization support with proper text domain
- **Debug-Friendly Code**: Extensive console logging and error reporting for development
- **Code Quality Standards**: Modern PHP syntax with type safety and clear documentation

### Technical Requirements
- **PHP**: 8.0 or higher (leverages match expressions, array spread, and modern namespaces)
- **WordPress**: 5.0 or higher (required for Gutenberg block support)
- **Dependencies**: jQuery (bundled with WordPress), WordPress Block Editor APIs

### Integration Details
- **External API**: Seamless integration with `https://forms.leadgenapp.io/js/lf.min.js/{id}`
- **Custom Elements**: Creates `<leadgen-form-{id}>` elements dynamically via external API
- **Data Flow**: PHP shortcode → wp_localize_script() → JavaScript configuration → External API
- **CSS Classes**: `.leadgen-form-container`, `.leadgen-form-placeholder`, `.leadgen-pulse-animation`
- **Block Namespace**: `leadgen/form-block` registered in WordPress block registry
- **File Structure**: Organized with `/blocks/`, `/includes/`, and `/assets/` directories
- **Namespace Structure**: `LeadGenAppForm` (main), `LeadGenAppForm\Block` (Gutenberg blocks)
- **Modern PHP Standards**: PHP 8.0+ features including match expressions and array spread
