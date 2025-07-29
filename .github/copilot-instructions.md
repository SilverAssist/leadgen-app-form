# LeadGen App Form Plugin - AI Coding Instructions

## Plugin Architecture

This is a **WordPress plugin** for integrating LeadGen App forms with minimal user interaction patterns and responsive design. The plugin follows WordPress best practices and modern PHP/JavaScript patterns.

### Plugin Structure
```
leadgen-app-form/
├── leadgen-app-form.php     # Main plugin file (Singleton pattern)
├── includes/                # Additional PHP classes
│   ├── class-leadgen-form-block.php # Gutenberg block handler
│   ├── class-leadgen-app-form-updater.php # Custom GitHub update system
│   ├── class-leadgen-app-form-admin.php # WordPress admin interface
│   └── elementor/                 # Elementor integration
│       ├── class-widgets-loader.php # Elementor widgets loader
│       └── widgets/               # Elementor widgets
│           └── class-leadgen-form-widget.php # LeadGen Form widget
├── blocks/                        # Gutenberg blocks
│   └── leadgen-form/             # LeadGen form block
│       ├── block.json            # Block metadata
│       ├── block.js              # Block JavaScript
│       └── editor.css            # Block editor styles
├── assets/                        # Static resources
│   ├── css/                      # Stylesheets
│   │   ├── leadgen-app-form.css  # Main plugin styles
│   │   └── leadgen-elementor.css # Elementor-specific styles
│   └── js/                       # JavaScript files
│       ├── leadgen-app-form.js   # Frontend functionality
│       └── leadgen-admin.js      # Admin update interface
├── .github/                      # GitHub Actions automation
│   └── workflows/                # Release automation workflows
│       ├── release.yml           # Main release workflow
│       └── check-size.yml        # Package information verification for PRs
├── scripts/                      # Release automation scripts
│   ├── calculate-size.sh         # Local package analysis calculation
│   ├── update-version.sh         # Automated version updating script
│   ├── check-versions.sh         # Version consistency verification script
│   └── README.md                 # Complete automation documentation
├── .eslintrc.json                # ESLint configuration for WordPress
├── README.md                     # Plugin documentation
├── CHANGELOG.md                  # Version change history
├── RELEASE-NOTES.md              # Generated release information
├── UPDATE-SYSTEM.md              # Update system documentation
├── HEADER-STANDARDS.md           # File header documentation standards
└── LICENSE                       # GPL v2 license
```

## Development Patterns

### PHP Coding Standards
- **Double quotes** for all strings: `"string"` not `'string'`
- **Short array syntax**: `[]` not `array()`
- **Namespaces**: `LeadGenAppForm` (main), `LeadGenAppForm\Block` (blocks), `LeadGenAppForm\Elementor\Widgets` (Elementor widgets)
- **Singleton pattern**: `LeadGen_App_Form::get_instance()`, `Widgets_Loader::get_instance()`
- **WordPress hooks**: `\add_action("init", [$this, "method"])`
- **PHP 8+ Features**: Match expressions, array spread, typed properties, namespaces
- **Global function calls**: Use `\` prefix for WordPress functions in namespaced context
- **Requires PHP 8.0+** for match expressions and advanced namespace features

### Modern PHP 8.0+ Features Implemented
- **Namespace Organization**: `LeadGenAppForm`, `LeadGenAppForm\Block`, and `LeadGenAppForm\Elementor\Widgets` namespaces
- **Match Expression**: `match (true) { condition => value, default => fallback }`
- **Array Spread in Arrays**: `[...array1, ...array2]` for efficient array building
- **Typed Properties**: `private static ?LeadGen_App_Form $instance = null` (PHP 7.4+)
- **Return Type Declarations**: `: void`, `: string`, `: array`, `: LeadGen_App_Form`
- **Null Coalescing Operator**: `$atts["desktop-id"] ?? ""`
- **Void Return Types**: Methods that don't return values explicitly marked `: void`
- **String Interpolation**: Use `"API URL: {$this->api_url}"` instead of concatenation for readability

### Automatic Update System
- **Public Repository Integration**: Works seamlessly with public GitHub repositories without authentication
- **WordPress Native Experience**: Updates appear in standard WordPress admin interface
- **Version Caching**: 12-hour intelligent caching to minimize API calls
- **Manual Update Checks**: Admin interface for immediate update verification
- **Background Processing**: Non-blocking update detection and processing
- **Error Handling**: Graceful fallback when GitHub API is unavailable
- **Professional Distribution**: GitHub Actions automate release package creation

#### Update System Components
```php
// Core updater class - handles GitHub API integration
LeadGen_App_Form_Updater::class
// Admin interface - manual update checks and status display
LeadGen_App_Form_Admin::class
// JavaScript handler - AJAX update checking
leadgen-admin.js
```

#### Update Flow Pattern
```
WordPress Admin → GitHub API → Version Check → Cache (12h) → Update Notification → One-Click Install
```

### String Interpolation Best Practices
- **API URLs**: `"https://api.github.com/repos/{$this->github_repo}/releases/latest"`
- **Download URLs**: `"https://github.com/{$this->github_repo}/releases/download/v{$version}/leadgen-app-form-v{$version}.zip"`
- **CSS Selectors**: `"#leadgen-form-wrap-{$form_id}"`
- **HTML Attributes**: `"data-desktop-id=\"{$desktop_id}\" data-mobile-id=\"{$mobile_id}\""`
- **Log Messages**: `"Loading form {$form_id} for {$device_type} device"`
- **Error Messages**: `"New version {$remote_version} is available! Current version: {$current_version}"`
- **Transient Names**: `"{$this->plugin_basename}_version_check"`

#### String Interpolation Examples
```php
// ✅ GOOD: Use string interpolation for readability
$api_url = "https://api.github.com/repos/{$this->github_repo}/releases/latest";
$message = "Version {$new_version} available (current: {$current_version})";
$selector = "#leadgen-form-{$form_id}";

// ❌ AVOID: String concatenation is harder to read
$api_url = "https://api.github.com/repos/" . $this->github_repo . "/releases/latest";
$message = "Version " . $new_version . " available (current: " . $current_version . ")";
$selector = "#leadgen-form-" . $form_id;

// ✅ GOOD: Complex interpolation with escaping
$html = "<div id=\"{$element_id}\" class=\"{$css_class}\" data-version=\"{$version}\"></div>";

// ✅ GOOD: JavaScript template literals (similar concept)
const apiUrl = `https://api.github.com/repos/${this.githubRepo}/releases/latest`;
const message = `Loading form ${formId} for ${deviceType} device`;
```

### JavaScript Architecture
- **Minimal User Interaction**: Forms load only on focus/mousemove/scroll/touchstart events
- **Responsive Design**: Dynamic form switching at 768px breakpoint
- **Global Configuration**: Uses `wp_localize_script()` with `leadGenAppSettings`
- **Script Management**: Tracks loaded scripts via Set() to prevent duplicates
- **Device Detection**: `DEVICE_TYPES.mobile` vs `DEVICE_TYPES.desktop`

### Implementation Methods
```php
// Basic usage - Shortcode
[leadgen_form desktop-id="uuid-desktop" mobile-id="uuid-mobile"]

// NEW in v1.0.3: Custom height attributes with responsive design
[leadgen_form desktop-id="uuid-desktop" mobile-id="uuid-mobile" desktop-height="800px" mobile-height="400px"]

// Height customization with different units (NEW in v1.0.3)
[leadgen_form desktop-id="uuid-desktop" mobile-id="uuid-mobile" desktop-height="50vh" mobile-height="300px"]

// Gutenberg Block - Preferred for block editor users (Enhanced in v1.0.3)
// Search "LeadGen Form" in block library, configure in sidebar
// NEW: Professional height controls with SelectControl for units and RangeControl sliders

// Elementor Widget - For Elementor page builder users (Enhanced in v1.0.3)
// Drag "LeadGen Form" widget from "LeadGen Forms" category
// NEW: SelectControl for units + NumberControl inputs with validation

// Flexible - works with one or both IDs
[leadgen_form desktop-id="uuid-desktop"]
[leadgen_form mobile-id="uuid-mobile"]
```

### Integration Methods
1. **Shortcode**: Direct shortcode usage in any post/page content with custom height support (v1.0.3)
2. **Gutenberg Block**: Visual block editor with professional height controls and live preview (Enhanced v1.0.3)
3. **Elementor Widget**: Native Elementor widget with organized height controls and validation (Enhanced v1.0.3)

## Critical Implementation Details

### Form Loading Process
1. **Placeholder Phase**: Gray box with CSS pulse animation
2. **Interaction Detection**: Waits for user events before script loading
3. **Dynamic Script Injection**: Loads from `https://forms.leadgenapp.io/js/lf.min.js/{id}`
4. **Custom Element Creation**: Injects `<leadgen-form-{id}>` elements
5. **Responsive Switching**: Automatically switches forms on viewport changes

### Data Flow Pattern
```
PHP Shortcode → extract_shortcode_instances() → wp_localize_script() → leadGenAppSettings → JavaScript destructuring → Form loading logic
```

### Key CSS Classes
- `.leadgen-form-container` - Main wrapper with data attributes
- `.leadgen-form-placeholder` - Placeholder with pulse animation
- `.leadgen-pulse-animation` - CSS keyframe animation
- `.leadgen-form-container.loaded` - Hides placeholder, shows form

### WordPress Integration Points
- **Script Loading**: Conditional via `has_shortcode()` detection
- **Data Sanitization**: All inputs use `sanitize_text_field()`
- **Translation Ready**: Text domain `"leadgen-app-form"`
- **Clean Architecture**: No activation/deactivation hooks needed (plugin doesn't modify WordPress internals)

### Elementor Integration Points
- **Widget Category**: Custom "LeadGen Forms" category in Elementor panel
- **Widget Class**: `LeadGenAppForm\Elementor\Widgets\LeadGen_Form_Widget`
- **Widgets Loader**: `LeadGenAppForm\Elementor\Widgets_Loader` singleton pattern
- **Conditional Loading**: Only loads when Elementor is active (`\did_action('elementor/loaded')`)
- **Style Dependencies**: `leadgen-elementor-css` extends main plugin styles
- **Control Types**: Uses Elementor `Controls_Manager::TEXT` for form IDs
- **Live Preview**: Visual configuration preview in Elementor editor
- **Error Handling**: User-friendly validation messages in editor mode
- **Consistent Rendering**: Uses same `render_shortcode()` method for consistency

## File Header Standards

All files in this plugin must follow standardized header documentation patterns:

### PHP Files (Main Plugin File)
```php
/**
 * Plugin Name: LeadGen App Form Plugin
 * Plugin URI: https://github.com/SilverAssist/leadgen-app-form
 * Description: WordPress plugin that adds a shortcode to display forms with desktop-id and mobile-id parameters.
 * Version: 1.0.0
 * Author: Silver Assist
 * Author URI: http://silverassist.com/
 * Text Domain: leadgen-app-form
 * Domain Path: /languages
 * Requires PHP: 8.0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package LeadGenAppForm
 * @since 1.0.0
 * @author Silver Assist
 */
```

### PHP Class Files
```php
/**
 * [File Name] - [Brief Description]
 *
 * [Detailed description of file functionality]
 *
 * @package LeadGenAppForm[/SubNamespace]
 * @since 1.0.0
 * @author Silver Assist
 */
```

### CSS Files
```css
/**
 * [File Name] - [Brief Description]
 *
 * [Detailed description of contained styles]
 *
 * @package LeadGenAppForm
 * @since 1.0.0
 * @author Silver Assist
 * @copyright Copyright (c) 2025, Silver Assist
 * @license GPL v2 or later
 * @version 1.0.0
 */
```

### JavaScript Files
```javascript
/**
 * [File Name] - [Brief Description]
 *
 * [Detailed description of JavaScript functionality]
 *
 * @file [filename.js]
 * @version 1.0.0
 * @author Silver Assist
 * @requires jQuery
 * @since 1.0.0
 */
```

**Header Standards Notes**:
- All files must include clear functionality descriptions
- Maintain current version (1.0.3) in @version across all files
- Use proper namespaces for PHP files according to file location
- CSS files should use copyright year 2025
- Author must always be "Silver Assist"
- License should be "GPL v2 or later" where applicable
- **@since vs @version**: `@since` indicates when introduced, `@version` indicates current version
- **New files in v1.0.1**: Use `@since 1.0.1` and `@version 1.0.1`
- **Existing files**: Keep original `@since`, update `@version` to 1.0.1
- See `HEADER-STANDARDS.md` for complete reference and examples

## Commit Message Standards

Follow these emoji conventions for clear and consistent commit history:

### Commit Types with Emojis

#### **🐛 Bug Fixes**
```bash
# For fixing bugs, errors, or issues
git commit -m "🐛 Fix form loading issue on mobile devices"
git commit -m "🐛 Resolve update notification display bug"
git commit -m "🐛 Fix Elementor widget configuration validation"
```

#### **✨ New Features**
```bash
# For adding new features or functionality
git commit -m "✨ Add automatic GitHub update system"
git commit -m "✨ Implement admin settings page for updates"
git commit -m "✨ Add real-time AJAX update checking"
```

#### **🔧 Fixes & Improvements**
```bash
# For general fixes, improvements, or maintenance
git commit -m "🔧 Improve error handling in update system"
git commit -m "🔧 Optimize script loading performance"
git commit -m "🔧 Update documentation with new features"
```

### Additional Commit Types
- **📚 Documentation**: `📚 Update README with v1.0.1 features`
- **🎨 Style/Format**: `🎨 Improve code formatting and structure`
- **♻️ Refactor**: `♻️ Refactor update system for better modularity`
- **⚡ Performance**: `⚡ Optimize form loading with smart caching`
- **🔒 Security**: `🔒 Enhance input validation and sanitization`
- **🚀 Release**: `🚀 Release v1.0.1 with automatic update system`

### Commit Message Format
```bash
<emoji> <type>: <description>

# Examples:
🐛 Fix mobile form detection logic
✨ Add Elementor widget support
🔧 Improve admin interface styling
📚 Update installation documentation
🚀 Release v1.0.1 with GitHub integration
```

### Best Practices
- **Clear descriptions**: Explain what was changed and why
- **Present tense**: "Add feature" not "Added feature"
- **Concise but descriptive**: Keep under 50 characters when possible
- **Reference issues**: Include issue numbers when applicable
- **Consistent emoji usage**: Follow the established pattern

## Development Commands

### Plugin Testing
```bash
# Activate plugin via WP-CLI
wp plugin activate leadgen-app-form

# Check for PHP syntax errors (main files)
php -l leadgen-app-form.php
php -l includes/class-leadgen-app-form-updater.php
php -l includes/class-leadgen-app-form-admin.php
php -l includes/elementor/class-widgets-loader.php
php -l includes/elementor/widgets/class-leadgen-form-widget.php

# Validate JavaScript
npx eslint assets/js/leadgen-app-form.js
npx eslint assets/js/leadgen-admin.js

# Test update system functionality
# - Go to WordPress Admin → Settings → LeadGen Forms
# - Click "Check for Updates" to test manual update checking

# Test Elementor integration (requires Elementor plugin active)
wp eval "if (class_exists('\\Elementor\\Plugin')) { echo 'Elementor is active'; } else { echo 'Elementor not found'; }"

# Check version consistency across all files
./scripts/check-versions.sh

# Update version across all plugin files
./scripts/update-version.sh 1.0.2
```

### Version Management
```bash
# Complete version update workflow
./scripts/check-versions.sh              # Check current consistency
./scripts/update-version.sh 1.0.2       # Update all files to new version
git diff                                 # Review changes
git add . && git commit -m "🔧 Update version to 1.0.2"
git tag v1.0.2 && git push origin main && git push origin v1.0.2
```

### Release Management
```bash
# Create automated release (recommended)
git add .
git commit -m "Prepare release v1.0.1"
git push origin main
git tag v1.0.1
git push origin v1.0.1

# Manual syntax validation before release
php -l leadgen-app-form.php
find includes/ -name "*.php" -exec php -l {} \;
npx eslint assets/js/ blocks/
```

### Debugging Helpers
- Console logging enabled for form initialization
- `window.LeadGenForm` API for manual control
- Error boundaries for failed script loads
- GitHub Actions automation for releases

## Extension Patterns

### Adding New Classes
```php
// In load_dependencies() method
require_once LEADGEP_APP_FORM_PLUGIN_PATH . "includes/class-admin-settings.php";

// For Elementor integration (conditional loading)
if (\did_action('elementor/loaded') || \class_exists('\\Elementor\\Plugin')) {
    require_once LEADGEP_APP_FORM_PLUGIN_PATH . "includes/elementor/class-widgets-loader.php";
}
```

### Elementor Widget Development Patterns
```php
// Widget class structure
namespace LeadGenAppForm\Elementor\Widgets;
class Custom_Widget extends Widget_Base {
    public function get_name(): string { return 'widget-name'; }
    public function get_title(): string { return __('Widget Title', 'leadgen-app-form'); }
    public function get_categories(): array { return ['leadgen-forms']; }
    protected function register_controls(): void { /* controls */ }
    protected function render(): void { /* output */ }
}

// Widget registration in loader
$widgets_manager->register(new \LeadGenAppForm\Elementor\Widgets\Custom_Widget());
```

### Elementor Integration Hooks
```php
// In Widgets_Loader class
\add_action('elementor/widgets/register', [$this, 'register_widgets']);
\add_action('elementor/elements/categories_registered', [$this, 'register_widget_category']);
\add_action('elementor/frontend/after_register_scripts', [$this, 'register_frontend_scripts']);
```

### Custom Hooks
```php
// Add in init() method for extensibility
do_action("leadgen_form_before_render", $atts);
do_action("leadgen_form_after_render", $form_id);
```

### CSS Customization
- Override styles in theme: `.leadgen-form-container { /* custom styles */ }`
- Responsive breakpoint: `@media (max-width: 768px)`
- Animation customization: `.leadgen-pulse-animation` keyframes
- Elementor-specific styles: `.elementor-leadgen-preview { /* editor preview */ }`
- Elementor editor enhancements: `.elementor-editor-active .leadgen-form-container`

## Code Quality & Development Tools

### ESLint Configuration
The plugin includes WordPress-specific ESLint configuration:

#### ESLint Setup (`.eslintrc.json`)
```json
{
  "env": {
    "browser": true,
    "es6": true,
    "jquery": true
  },
  "extends": ["eslint:recommended"],
  "globals": {
    "wp": "readonly",
    "jQuery": "readonly",
    "$": "readonly",
    "leadGenAppSettings": "readonly"
  },
  "rules": {
    "quotes": ["error", "double"],
    "semi": ["error", "always"],
    "no-unused-vars": "warn",
    "no-console": "off"
  }
}
```

#### Code Standards Enforcement
- **Double quotes**: All JavaScript strings must use `"` not `'`
- **WordPress globals**: `wp`, `jQuery`, `$` available globally
- **Plugin globals**: `leadGenAppSettings` from `wp_localize_script()`
- **Semi-colons**: Required for all statements
- **Console logging**: Allowed for debugging (no-console: off)

### Development Workflow Integration
```bash
# Lint JavaScript before commits
npx eslint assets/js/ blocks/

# Auto-fix formatting issues
npx eslint assets/js/ blocks/ --fix

# Check specific file
npx eslint assets/js/leadgen-app-form.js
```

## Key Files Reference
- **Entry Point**: `leadgen-app-form.php` (Singleton class)
- **Gutenberg Block**: `includes/class-leadgen-form-block.php` (Block handler)
- **Update System**: `includes/class-leadgen-app-form-updater.php` (GitHub API integration)
- **Admin Interface**: `includes/class-leadgen-app-form-admin.php` (Update management)
- **Elementor Loader**: `includes/elementor/class-widgets-loader.php` (Widgets manager)
- **Elementor Widget**: `includes/elementor/widgets/class-leadgen-form-widget.php` (LeadGen Form widget)
- **Frontend Logic**: `assets/js/leadgen-app-form.js` (Vanilla JS + jQuery)
- **Admin JavaScript**: `assets/js/leadgen-admin.js` (Update status handling)
- **Main Styles**: `assets/css/leadgen-app-form.css` (Responsive + animations)
- **Elementor Styles**: `assets/css/leadgen-elementor.css` (Elementor-specific styling)
- **Documentation**: `README.md` (User-facing docs), `UPDATE-SYSTEM.md` (Update system guide)
- **Release Process**: `RELEASE-PROCESS.md` (Complete manual release workflow documentation)
- **Development Guide**: `.github/copilot-instructions.md` (This file - complete development patterns)

## Release Management & Automation

### Automated Release System
The plugin includes a comprehensive automated release system with GitHub Actions workflows:

#### GitHub Actions Workflows
- **`.github/workflows/release.yml`** - Main release automation workflow
- **`.github/workflows/check-size.yml`** - Package information verification for PRs

#### Local Scripts
- **`scripts/calculate-size.sh`** - Local package analysis calculation script
- **`scripts/README.md`** - Complete automation documentation

### Release Process
#### Option A: Automated Release (Recommended)
```bash
# 1. Update CHANGELOG.md with new version changes
# 2. Commit and push changes
git add .
git commit -m "Prepare release v1.0.1"
git push origin main

# 3. Create and push tag - triggers automation
git tag v1.0.1
git push origin v1.0.1

# GitHub Actions automatically:
# - Updates versions in all files (@version fields)
# - Creates optimized distribution ZIP
# - Creates optimized distribution ZIP
# - Updates RELEASE-NOTES.md
# - Creates GitHub Release with attachments
```

#### Option B: Manual Workflow Dispatch
1. Go to GitHub → Actions → "Create Release Package"
2. Click "Run workflow"
3. Enter version (e.g., 1.0.1)
4. Click "Run workflow"

### Package Management
#### Distribution Package
**Included Files:**
- `leadgen-app-form.php`
- `includes/` (PHP classes)
- `blocks/` (Gutenberg integration)
- `assets/` (CSS/JS)
- `README.md`, `CHANGELOG.md`, `LICENSE`

**Excluded Files:**
- `.git/`, `.github/` (development)
- `.eslintrc.json`, `.eslintignore` (linting)
- `scripts/` (development tools)
- `HEADER-STANDARDS.md` (development documentation)
- `RELEASE-NOTES.md` (generated file)
- `RELEASE-PROCESS.md` (development documentation)
- `QUICK-RELEASE.md` (development documentation)
- `UPDATE-SYSTEM.md` (development documentation)

#### Automatic Version Management
The release system automatically updates `@version` fields in:
- Main plugin file (`leadgen-app-form.php`)
- All PHP files in `includes/`
- All CSS files in `assets/css/`
- All JavaScript files in `assets/js/` and `blocks/`

### Pull Request Integration
When creating PRs, GitHub Actions automatically:
- Calculates current package information
- Comments on PR with package details
- Updates comments when changes are made
- Provides package comparison for review

### Release Documentation
Complete automation documentation available at:
- **English**: `scripts/README.md`
- **System Overview**: Comprehensive workflows and troubleshooting

### Manual Release Process
For complete step-by-step release instructions, see **`RELEASE-PROCESS.md`**

#### Quick Release Reference
```bash
# 1. Update documentation
# - Update CHANGELOG.md with new version changes
# - Update README.md if features changed

# 2. Version management
./scripts/update-version-simple.sh 1.0.X
./scripts/check-versions.sh

# 3. Commit and tag
git add CHANGELOG.md README.md
git commit -m "📚 Update documentation for v1.0.X release"
git tag v1.0.X
git push origin main && git push origin v1.0.X

# 4. Monitor GitHub Actions for automated release
```

#### Critical Pre-Release Steps
1. **Documentation Updates**: Always update `CHANGELOG.md` before creating tags
2. **Version Consistency**: Use scripts to ensure all files have matching versions
3. **Testing**: Verify ESLint passes and PHP syntax is valid
4. **Commit Order**: Documentation first, then tag creation to trigger automation

#### Release Artifacts
- Distribution ZIP with optimized file structure
- GitHub Release with complete changelog
- RELEASE-NOTES.md automatically generated
- Package artifacts with 90-day retention
