# LeadGen App Form Plugin

WordPress plugin that adds a shortcode to display forms with different configurations for desktop and mobile devices.

## Features

- **🚀 NEW in v1.0.3**: Advanced height controls with professional UI for Gutenberg and Elementor
- **⚙️ NEW**: Numeric input controls with unit selector (px, em, rem, vh, vw, %) for precise height configuration
- **🔧 NEW**: Smart shortcode generation that only includes height attributes when they differ from defaults
- **🎨 NEW**: Organized control panels with separators, headings, and live preview feedback
- **🚀 Updated in v1.0.1**: Professional automatic update system with GitHub integration
- **⚙️ Updated in v1.0.1**: WordPress admin settings page for update management and status
- **🔄 Updated in v1.0.1**: Real-time AJAX update checking with manual update functionality
- **📦 Updated in v1.0.1**: GitHub Actions automation for professional release management
- **Gutenberg Block Integration**: Visual block editor with advanced height controls
- **Elementor Widget Support**: Native Elementor widget for page builder users
- **Intuitive User Interface**: Sidebar controls with live preview
- **Multiple Integration Methods**: Shortcode, Gutenberg block, and Elementor widget
- Customizable shortcode with desktop and mobile parameters
- Automatic mobile device detection
- Optimized script loading (only when shortcode is used)
- Minimal user interaction pattern for performance
- Responsive design with viewport switching
- CSS pulse animation placeholder
- External form script management
- Modern PHP 8.0+ features and syntax
- Translation ready with proper text domain
- Organized folder structure for maintainability

## Requirements

- WordPress 5.0 or higher
- PHP 8.0 or higher

## Download

The plugin is available as a ready-to-install ZIP file:
- **File**: `leadgen-app-form-v1.0.3.zip` (~51KB)
- **Version**: 1.0.3
- **Compatibility**: WordPress 5.0+ with PHP 8.0+
- **New in v1.0.3**: Custom placeholder height attributes with responsive design

## Installation

### Method 1: WordPress Admin Dashboard (Recommended)

1. **Download the Plugin**: Download the `leadgen-app-form.zip` file
2. **Access WordPress Admin**: Log in to your WordPress admin dashboard
3. **Navigate to Plugins**: Go to `Plugins` → `Add New`
4. **Upload Plugin**: Click the `Upload Plugin` button at the top of the page
5. **Choose File**: Click `Choose File` and select the `leadgen-app-form.zip` file
6. **Install**: Click `Install Now` and wait for the upload to complete
7. **Activate**: Click `Activate Plugin` to enable the LeadGen App Form plugin

### Method 2: Manual Installation via FTP

1. **Extract the ZIP**: Unzip the `leadgen-app-form.zip` file on your computer
2. **Upload via FTP**: Upload the extracted `leadgen-app-form` folder to the `/wp-content/plugins/` directory on your server
3. **Activate**: Go to the WordPress admin panel and activate the plugin from the `Plugins` page

### Method 3: WP-CLI Installation

If you have WP-CLI installed, you can also install the plugin using the command line:

```bash
# Upload and install the plugin
wp plugin install leadgen-app-form.zip --activate

# Or manually activate after uploading
wp plugin activate leadgen-app-form
```

### Verification

After installation, you should see:
- **Gutenberg Block**: "LeadGen Form" block available in the block editor
- **Elementor Widget**: "LeadGen Form" widget in the "LeadGen Forms" category (if Elementor is installed)
- **Shortcode Support**: `[leadgen_form]` shortcode ready to use

## Automatic Updates

The plugin includes a professional automatic update system that connects directly to this GitHub repository:

### ✅ **Zero Configuration Required**
- **Automatic Detection**: WordPress checks for new versions every 12 hours
- **Native Experience**: Updates appear in the standard WordPress Plugins page
- **One-Click Updates**: Install updates with a single click
- **Update Notifications**: Get notified when new versions are available

### 🔧 **Manual Update Check**
```
WordPress Admin → Settings → LeadGen Forms → Check for Updates
```

### 📋 **Update Features**
- **Version Caching**: Efficient API usage with smart caching
- **Error Handling**: Graceful fallback if updates are unavailable
- **Background Processing**: Non-blocking update checks
- **Release Notes**: Automatic changelog integration

The update system works seamlessly with public GitHub repositories and requires no additional configuration.

## Usage

### Gutenberg Block (Recommended)

The easiest and most user-friendly way to add a LeadGen form is using the Gutenberg block:

1. **Add the Block**: In the WordPress editor, click the "+" button to add a new block
2. **Find LeadGen Form**: Search for "LeadGen Form" in the block library or browse the "Widgets" category
3. **Configure Settings**: Use the block sidebar panel to configure your form IDs:
   - **Desktop Form ID**: ID for desktop and tablet devices
   - **Mobile Form ID**: ID specifically for mobile devices
4. **Live Preview**: The block shows a visual preview with configuration status
5. **Publish**: The form will automatically display with responsive behavior

#### Block Features
- **Visual Configuration**: No need to remember shortcode syntax
- **Professional Height Controls**: Separate panel with SelectControl for units and RangeControl sliders
- **Live Validation**: Real-time validation ensures at least one ID is configured
- **Intelligent Preview**: Shows current settings including custom heights only when they differ from defaults
- **Smart Shortcode Generation**: Optimized shortcode output that excludes unnecessary default values
- **Responsive Indicators**: Visual hints about desktop/mobile behavior and custom heights
- **Error Prevention**: Range controls prevent invalid height values automatically
- **Organized UI**: Clean panel separation between form IDs and height settings

### Elementor Widget Integration

For sites using Elementor page builder instead of Gutenberg, the plugin includes a dedicated Elementor widget:

#### Using the Elementor Widget

1. **Open Elementor Editor**: Edit any page/post with Elementor
2. **Find LeadGen Widget**: Search for "LeadGen Form" in the widget panel or browse the "LeadGen Forms" category
3. **Drag & Drop**: Add the widget to your desired location
4. **Configure Form IDs**: Use the widget settings panel to set:
   - **Desktop Form ID**: ID for desktop and tablet devices  
   - **Mobile Form ID**: ID specifically for mobile devices
5. **Style Options**: Access additional styling options in the Style tab:
   - Form alignment (left, center, right)
   - Form width settings
6. **Preview**: View live preview with configuration status
7. **Publish**: The form integrates seamlessly with your Elementor design

#### Elementor Widget Features
- **Native Elementor Integration**: Fully integrated with Elementor's interface
- **Visual Preview**: Shows configuration preview directly in the editor
- **Professional Height Controls**: SelectControl for units + NumberControl inputs with validation
- **Organized UI**: Separators, headings, and logical grouping of controls
- **Live Configuration Preview**: Shows configured heights in the editor preview panel
- **Error Prevention**: Visual validation ensures proper configuration
- **Responsive Options**: Control appearance on different devices including custom heights
- **Consistency**: Uses the same shortcode logic for reliable behavior across all methods
- **Category Organization**: Grouped under "LeadGen Forms" category

### Shortcode Usage

You can also use the `[leadgen_form]` shortcode directly:

```
[leadgen_form desktop-id="form-desktop-001" mobile-id="form-mobile-001" desktop-height="600px" mobile-height="300px"]
```

### Parameters

- `desktop-id` (optional): Form ID for desktop devices
- `mobile-id` (optional): Form ID for mobile devices
- `desktop-height` (optional): Custom placeholder height for desktop devices (default: 600px)
- `mobile-height` (optional): Custom placeholder height for mobile devices (default: 300px)

**Note**: At least one form ID parameter is required. The plugin intelligently handles fallbacks.

### Usage Examples

```php
// Full configuration with custom heights
[leadgen_form desktop-id="uuid-desktop" mobile-id="uuid-mobile" desktop-height="800px" mobile-height="400px"]

// Both IDs with default heights
[leadgen_form desktop-id="uuid-desktop" mobile-id="uuid-mobile"]

// Desktop only with custom height
[leadgen_form desktop-id="uuid-desktop" desktop-height="700px"]

// Custom heights with different units
[leadgen_form desktop-id="uuid-desktop" mobile-id="uuid-mobile" desktop-height="50vh" mobile-height="300px"]

// Using percentage heights
[leadgen_form desktop-id="uuid-desktop" mobile-id="uuid-mobile" desktop-height="80%" mobile-height="60%"]
```

#### Device Logic
- **Both IDs provided**: Uses mobile ID on mobile devices, desktop ID on desktop/tablet
- **Desktop ID only**: Uses desktop ID for all devices  
- **Mobile ID only**: Uses mobile ID for all devices
- **No IDs**: Shows error message (block prevents this)

#### Height Customization
- **Supported units**: px, em, rem, vh, vw, % (e.g., "600px", "50vh", "80%")
- **Default heights**: 600px for desktop, 300px for mobile
- **Responsive behavior**: Heights automatically adjust based on device viewport
- **Validation**: Invalid height values fallback to defaults with console warnings

## Plugin Structure

```
leadgen-app-form/
├── leadgen-app-form.php           # Main plugin file (Singleton pattern)
├── includes/                      # Additional PHP classes
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
│       └── check-size.yml        # Package size verification for PRs
├── scripts/                      # Release automation scripts
│   ├── calculate-size.sh         # Local package size calculation
│   ├── update-version.sh         # Automated version updating script
│   ├── check-versions.sh         # Version consistency verification script
│   └── README.md                 # Complete automation documentation
├── .eslintrc.json                # ESLint configuration for WordPress
├── README.md                     # This file - Plugin documentation
├── CHANGELOG.md                  # Version change history
├── RELEASE-NOTES.md              # Generated release information
├── UPDATE-SYSTEM.md              # Update system documentation
├── HEADER-STANDARDS.md           # File header documentation standards
└── LICENSE                       # GPL v2 license
```

## Development

The plugin is developed following WordPress and modern PHP best practices:

### Architecture & Patterns
- **Singleton Pattern**: Main class and block handler use singleton for memory efficiency
- **Server-Side Rendering**: Gutenberg block uses PHP rendering for better SEO
- **Hook-Based Architecture**: Clean separation of concerns using WordPress hooks
- **Conditional Loading**: Assets only load when needed (shortcode/block present)
- **Custom Update System**: Professional GitHub-integrated update management

### Code Quality Standards
- **Data Sanitization**: All user inputs properly sanitized
- **Input Validation**: Comprehensive validation for form IDs and attributes
- **Translation Support**: Full i18n support with proper text domain
- **Error Handling**: Graceful degradation and user-friendly error messages
- **Documentation**: Complete PHPDoc and JSDoc documentation
- **Version Control**: Standardized file headers with proper @since/@version tracking

### Technical Implementation
- **Modern PHP Syntax**: PHP 8.0+ features for better performance
- **Minimal user interaction**: Performance-optimized loading pattern
- **Responsive Design**: Mobile-first approach with viewport switching
- **External API Integration**: Clean integration with LeadGen App API
- **Block Editor Integration**: Native Gutenberg block with visual interface
- **Elementor Integration**: Custom widget with native Elementor interface
- **Namespace Organization**: Clean code organization using PHP namespaces
- **GitHub Actions**: Automated release and package management

### Update System Features (New in v1.0.1)
- **GitHub API Integration**: Direct connection to public GitHub releases
- **WordPress Native Experience**: Updates appear in standard WordPress plugins page
- **Intelligent Caching**: 12-hour caching system for optimal performance
- **Manual Update Checks**: Admin interface for immediate update verification
- **Version Comparison**: Smart semantic version handling and comparison
- **Error Handling**: Graceful fallback when GitHub API is unavailable
- **Release Automation**: Complete GitHub Actions workflow for releases

### Integration Methods
- **Shortcode**: Direct shortcode usage in any post/page content
- **Gutenberg Block**: Visual block editor with sidebar controls and live preview
- **Elementor Widget**: Native Elementor widget with drag-and-drop interface and styling controls

### Elementor-Specific Features
- **Widget Category**: Organized under "LeadGen Forms" category
- **Live Preview**: Visual preview directly in Elementor editor
- **Style Controls**: Additional styling options (alignment, width, responsive settings)
- **Error Handling**: Visual validation and user-friendly error messages
- **Consistent Rendering**: Uses the same shortcode logic for reliable behavior across all methods

## PHP 8.0+ Features

This plugin leverages modern PHP 8.0+ features for improved performance and code quality:

### Implemented Features
- **Namespaces**: Clean code organization with `LeadGenAppForm`, `LeadGenAppForm\Block`, and `LeadGenAppForm\Elementor\Widgets` namespaces
- **Match Expression**: Cleaner conditional logic replacing complex if/else chains
- **Array Spread in Array Expression**: More efficient array building using `...` operator
- **Typed Properties**: Type-safe nullable properties (PHP 7.4+)
- **Return Type Declarations**: Clear return types for all methods
- **Null Coalescing Operator (??)**:  Cleaner default value handling
- **Void Return Type**: Explicit void returns for clarity

### Code Examples
```php
// Namespace organization
namespace LeadGenAppForm;
namespace LeadGenAppForm\Block;

// Match expression (PHP 8.0+)
$current_id = match (true) {
  $is_mobile && !empty($mobile_id) => $mobile_id,
  !empty($desktop_id) => $desktop_id,
  default => ""
};

// Array spread in array expression (PHP 8.0+)
$shortcode_atts = [
  ...(!empty($desktop_id) ? ["desktop-id=\"{$desktop_id}\""] : []),
  ...(!empty($mobile_id) ? ["mobile-id=\"{$mobile_id}\""] : [])
];

// Typed properties (PHP 7.4+)
private static ?LeadGen_App_Form $instance = null;

// Global function calls in namespaced context
\wp_enqueue_script(...);
```

## How It Works

### Loading Process
1. **Placeholder Display**: Shows animated gray placeholder
2. **User Interaction Detection**: Waits for focus, mousemove, scroll, or touch events
3. **Dynamic Script Loading**: Loads external form scripts from LeadGen App
4. **Form Rendering**: Injects custom elements and displays the actual form
5. **Responsive Switching**: Automatically switches forms on viewport changes

### Technical Details
- **External API**: Integrates with `https://forms.leadgenapp.io/js/lf.min.js/{id}`
- **Custom Elements**: Creates `<leadgen-form-{id}>` elements dynamically
- **Script Management**: Prevents duplicate script loading
- **Performance**: Only loads resources when needed

## Development Notes

To extend functionality, you can:

1. Add new classes in the `includes/` folder
2. Create custom styles in `assets/css/`
3. Implement custom hooks and filters
4. Add admin configuration options
5. Extend the JavaScript API
6. Customize the update system behavior

### Update System API (New in v1.0.1)
```php
// Access the updater instance
$updater = new LeadGen_App_Form_Updater(__FILE__, "SilverAssist/leadgen-app-form");

// Manual version check
$remote_version = $updater->get_remote_version();

// Get current version
$current_version = $updater->get_current_version();

// Access admin interface
$admin = new LeadGen_App_Form_Admin($updater);
```

### Admin Interface Features
- **Settings Page**: WordPress Admin → Settings → LeadGen Forms
- **Update Status**: Real-time update checking with AJAX
- **Manual Updates**: Force check for updates anytime
- **Version Display**: Current and available version information
- **GitHub Integration**: Direct links to repository and releases

### JavaScript API
```javascript
// Public API available for advanced integrations
window.LeadGenForm.loadForm("container-id");     // Manually load specific form
window.LeadGenForm.unloadForm("container-id");   // Unload and cleanup form
window.LeadGenForm.getLoadedForms();             // Get array of loaded form IDs
window.LeadGenForm.isFormLoaded("form-id");      // Check if specific form is loaded
window.LeadGenForm.reloadForm("container-id");   // Reload form (useful for dynamic content)
```

### Admin JavaScript API (New in v1.0.1)
```javascript
// Admin update checking functionality
leadgenAdmin.ajax_url;     // WordPress AJAX URL
leadgenAdmin.nonce;        // Security nonce for AJAX requests
leadgenAdmin.strings;      // Localized strings for admin interface
```

### Gutenberg Block Development
```javascript
// Block registration details
wp.blocks.registerBlockType("leadgen/form-block", {
  title: "LeadGen Form",
  category: "widgets",
  supports: {
    align: ["wide", "full"],
    spacing: { margin: true, padding: true }
  }
});
```

### Debugging & Monitoring
- **Console Logging**: Detailed form initialization and loading logs
- **Error Handling**: Comprehensive error catching for failed script loads
- **Viewport Tracking**: Real-time monitoring of responsive form switches
- **Performance Metrics**: Script loading times and interaction delays
- **Block Validation**: Editor-time validation of form configurations

## 🛠️ Development & Release Management

### For Developers
This plugin includes comprehensive development tools and automation:

#### Version Management
- **Automated Scripts**: `./scripts/update-version-simple.sh` for consistent version updates
- **Consistency Checking**: `./scripts/check-versions.sh` for validation
- **Release Process**: Complete workflow documented in [RELEASE-PROCESS.md](RELEASE-PROCESS.md)

#### Release Workflow
For detailed release instructions, see **[RELEASE-PROCESS.md](RELEASE-PROCESS.md)**

Quick release checklist:
1. Update [CHANGELOG.md](CHANGELOG.md) with new version changes
2. Update [README.md](README.md) if features changed
3. Run version update: `./scripts/update-version-simple.sh 1.0.X`
4. Commit documentation: `git commit -m "📚 Update documentation for vX.X.X"`
5. Create release tag: `git tag vX.X.X && git push origin vX.X.X`
6. Monitor [GitHub Actions](https://github.com/SilverAssist/leadgen-app-form/actions) for automated release

#### Development Resources
- **Plugin Structure**: See [copilot-instructions.md](copilot-instructions.md) for complete architecture
- **Update System**: Documented in [UPDATE-SYSTEM.md](UPDATE-SYSTEM.md)
- **File Headers**: Standards in [HEADER-STANDARDS.md](HEADER-STANDARDS.md)
- **GitHub Actions**: Automated release workflow in `.github/workflows/`

## 📋 Support & Documentation

### Documentation Files
- **User Guide**: This README.md
- **Release Process**: [RELEASE-PROCESS.md](RELEASE-PROCESS.md) (for developers)
- **Change History**: [CHANGELOG.md](CHANGELOG.md)
- **Update System**: [UPDATE-SYSTEM.md](UPDATE-SYSTEM.md)
- **Development**: [copilot-instructions.md](copilot-instructions.md)

### Support
- **Issues**: [GitHub Issues](https://github.com/SilverAssist/leadgen-app-form/issues)
- **Releases**: [GitHub Releases](https://github.com/SilverAssist/leadgen-app-form/releases)
- **Repository**: [GitHub Repository](https://github.com/SilverAssist/leadgen-app-form)

## 📄 License

This plugin is licensed under the GPL v2 or later.

---

**💡 For complete development workflows and release procedures, see [RELEASE-PROCESS.md](RELEASE-PROCESS.md)**
