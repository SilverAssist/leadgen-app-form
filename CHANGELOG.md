# Changelog

All notable changes to the LeadGen App Form Plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.3] - 2025-07-28

### Added - Professional Height Control UI
- **Shortcode Height Customization**: Added `desktop-height` and `mobile-height` attributes to `[leadgen_form]` shortcode
- **Professional UI Controls**: Advanced controls with SelectControl for units and NumberControl/RangeControl inputs
- **Organized Control Panels**: Clean separation with dividers, headings, and logical grouping in both Gutenberg and Elementor
- **Live Preview Enhancement**: Real-time preview showing configured heights in editor interfaces
- **Smart Shortcode Generation**: Intelligent shortcode output that only includes height attributes when customized
- **Enhanced Validation**: Range controls and NumberControl inputs prevent invalid height values automatically
- **Cross-Platform Consistency**: Identical functionality between Gutenberg blocks and Elementor widgets
- **Multiple Unit Support**: Support for px, em, rem, vh, vw, and percentage units with descriptive labels
- **Responsive Height Support**: Automatic height adjustment based on device viewport with smooth transitions
- **CSS Transitions**: Smooth height changes with 0.3s ease transitions for professional appearance

### Enhanced - User Experience Improvements
- **Gutenberg Block UI**: Separate "Placeholder Height Settings" panel with professional SelectControl and RangeControl
- **Elementor Widget UI**: Organized controls with separators, headings, and NumberControl inputs for precision
- **Visual Feedback**: Live preview showing current height configuration in both editor interfaces
- **Error Prevention**: Range validation prevents extreme values (1-2000 range) with automatic defaults
- **Smart Defaults**: Height controls show meaningful defaults (600px desktop, 300px mobile)
- **Intelligent Organization**: Visual grouping with separators and descriptive headings for better UX

### Enhanced - Technical Improvements
- **SelectControl Integration**: Professional unit selector with descriptive labels for better clarity
- **RangeControl Implementation**: Smooth slider controls for precise height adjustment in Gutenberg
- **NumberControl Addition**: Direct numeric input for Elementor widget precision and validation
- **Smart Attribute Handling**: Only outputs height attributes when they differ from defaults for clean shortcodes
- **Enhanced JavaScript**: Improved client-side validation with regex pattern matching for units
- **Updated Documentation**: Complete examples and usage guide for all new professional controls

## [1.0.2] - 2025-07-28

### Added - Version Management Automation
- **Automated Version Update Script**: `update-version.sh` - Comprehensive script for updating all plugin file versions simultaneously
- **Version Consistency Checker**: `check-versions.sh` - Validation tool to ensure version consistency across all files
- **Interactive Version Updates**: Confirmation prompts and detailed progress reporting during version changes
- **Comprehensive File Coverage**: Automatic updates for PHP, CSS, JavaScript, and block metadata files
- **Development Workflow Integration**: Complete automation scripts integrated into development documentation
- **Smart Version Detection**: Automatic detection of current versions with validation before updates
- **Colorized Output**: Visual feedback with color-coded status messages for better developer experience
- **Safety Validations**: Semantic version format checking and confirmation prompts prevent errors

### Enhanced - Plugin Structure Documentation
- **Updated Documentation**: README.md and copilot instructions reflect new automation scripts
- **Complete File Mapping**: Updated plugin structure to include all automation and development tools
- **Release Workflow Integration**: Version management scripts integrated into release procedures

### Fixed - Development Experience
- **Streamlined Version Updates**: Eliminates manual version updating across multiple files
- **Reduced Human Error**: Automated validation prevents version inconsistencies
- **Improved Developer Productivity**: One-command version updates for efficient release cycles

## [1.0.1] - 2025-07-27

### Added - Automatic Update System
- **Custom GitHub Update Integration**: Professional update system using GitHub API for public repositories
- **WordPress Native Experience**: Updates appear in standard WordPress admin interface alongside core and plugin updates
- **Admin Settings Page**: Dedicated admin interface at Settings → LeadGen Forms for update management
- **Manual Update Checking**: One-click "Check for Updates" button for immediate update verification
- **Real-Time AJAX Status**: Dynamic update status display without page refresh
- **Intelligent Caching System**: 12-hour caching to minimize GitHub API calls and improve performance
- **Version Comparison Logic**: Smart version detection with proper semantic version handling
- **Background Processing**: Non-blocking update detection that doesn't impact site performance
- **Error Handling & Fallbacks**: Graceful degradation when GitHub API is unavailable
- **Professional Distribution**: Automated release packages (~38KB) with optimized file structure

### Added - GitHub Actions Automation
- **Automated Release Workflow**: Complete release automation via GitHub Actions
- **Package Size Verification**: Automatic package size calculation and verification for releases
- **Pull Request Integration**: Package size reporting on pull requests for transparency
- **Version Management**: Automatic version bumping across all plugin files
- **Distribution Optimization**: Excludes development files from release packages
- **Release Documentation**: Auto-generated RELEASE-NOTES.md with each release
- **Quality Assurance**: Automated syntax checking and code validation

### Added - Admin Interface & User Experience
- **Settings Page Integration**: Native WordPress admin page with professional styling
- **Update Status Dashboard**: Clear display of current version, available updates, and system status
- **User-Friendly Notifications**: Professional update notifications with clear call-to-action
- **AJAX-Powered Interface**: Smooth user experience with real-time status updates
- **Error Reporting**: Clear error messages and troubleshooting information
- **Professional Styling**: Consistent with WordPress admin design patterns
- **Accessibility Features**: Screen reader compatible and keyboard navigation support

### Added - Technical Infrastructure
- **Public Repository Architecture**: Optimized for public GitHub repositories without authentication overhead
- **WordPress Transient Caching**: Efficient caching using WordPress native transient API
- **Hook Integration**: Seamless integration with WordPress update hooks and filters
- **API Error Handling**: Robust error handling for network issues and API limitations
- **Security Best Practices**: Secure update delivery and verification processes
- **Performance Optimization**: Minimal impact on site performance with smart caching

### Added - Developer Experience
- **Comprehensive Documentation**: Complete update system documentation in UPDATE-SYSTEM.md
- **Code Quality Standards**: ESLint configuration for WordPress JavaScript development
- **Header Standards**: Standardized file headers across all plugin files in HEADER-STANDARDS.md
- **String Interpolation Patterns**: Modern PHP string interpolation for improved code readability
- **Development Commands**: Complete testing and validation commands for all plugin components
- **Release Automation**: Scripts for local package size calculation and release preparation

### Technical Enhancements
- **New PHP Classes**:
  - `LeadGen_App_Form_Updater` - GitHub API integration and update logic
  - `LeadGen_App_Form_Admin` - WordPress admin interface and settings management
- **New JavaScript**: `leadgen-admin.js` - AJAX handlers for real-time update status
- **Enhanced Error Handling**: Comprehensive error boundaries and user-friendly error messages
- **Modern PHP Practices**: Continued use of PHP 8.0+ features with improved string interpolation
- **WordPress Integration**: Deep integration with WordPress update infrastructure

### Update System Features
- **GitHub API Integration**: Direct integration with GitHub releases API for update detection
- **No Authentication Required**: Works seamlessly with public repositories
- **Professional Update Flow**: Standard WordPress update experience users expect
- **Automatic Version Detection**: Intelligent comparison of local vs. remote versions
- **One-Click Updates**: Standard WordPress "Update Now" functionality
- **Update Verification**: Ensures successful update installation and activation

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
- **Namespace Structure**: `LeadGenAppForm` (main), `LeadGenAppForm\Block` (Gutenberg blocks), `LeadGenAppForm\Elementor\Widgets` (Elementor widgets)
- **Modern PHP Standards**: PHP 8.0+ features including match expressions, array spread, and string interpolation
- **Update System Integration**: GitHub API → WordPress transients → Admin interface → Native WordPress updates
- **Admin Integration**: Settings → LeadGen Forms admin page with real-time update status
- **Release Automation**: GitHub Actions → Automated releases → Update notifications
