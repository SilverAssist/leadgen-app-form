# LeadGen App Form Plugin

WordPress plugin that adds a shortcode to display forms with different configurations for desktop and mobile devices.

## Features

- **Gutenberg Block Integration**: Visual block editor for easy form insertion
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
- **File**: `leadgen-app-form-plugin.zip` (≈37KB)
- **Version**: 1.0.0
- **Compatibility**: WordPress 5.0+ with PHP 8.0+

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
- **Live Validation**: Real-time validation ensures at least one ID is configured
- **Configuration Preview**: Shows current settings and device targeting
- **Responsive Indicators**: Visual hints about desktop/mobile behavior
- **Error Prevention**: Prevents invalid configurations

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
- **Style Controls**: Additional styling options for alignment and sizing  
- **Error Prevention**: Visual validation ensures proper configuration
- **Responsive Options**: Control appearance on different devices
- **Consistency**: Uses the same shortcode logic for reliable behavior
- **Category Organization**: Grouped under "LeadGen Forms" category

### Shortcode Usage

You can also use the `[leadgen_form]` shortcode directly:

```
[leadgen_form desktop-id="form-desktop-001" mobile-id="form-mobile-001"]
```

### Parameters

- `desktop-id` (optional): Form ID for desktop devices
- `mobile-id` (optional): Form ID for mobile devices

**Note**: At least one parameter is required. The plugin intelligently handles fallbacks.

### Usage Examples

```php
// Both IDs (recommended for optimal responsive experience)
[leadgen_form desktop-id="uuid-desktop" mobile-id="uuid-mobile"]

// Desktop only (will fallback to desktop on mobile)
[leadgen_form desktop-id="uuid-desktop"]

// Mobile only (will use mobile for all devices)
[leadgen_form mobile-id="uuid-mobile"]
```

#### Device Logic
- **Both IDs provided**: Uses mobile ID on mobile devices, desktop ID on desktop/tablet
- **Desktop ID only**: Uses desktop ID for all devices
- **Mobile ID only**: Uses mobile ID for all devices
- **No IDs**: Shows error message (block prevents this)

## Plugin Structure

```
leadgen-app-form/
├── leadgen-app-form.php           # Main plugin file
├── includes/                      # Additional classes and functions
│   ├── class-leadgen-form-block.php # Gutenberg block handler
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
│       └── leadgen-app-form.js   # Frontend functionality
└── README.md                      # This file
```

## Development

The plugin is developed following WordPress and modern PHP best practices:

### Architecture & Patterns
- **Singleton Pattern**: Main class and block handler use singleton for memory efficiency
- **Server-Side Rendering**: Gutenberg block uses PHP rendering for better SEO
- **Hook-Based Architecture**: Clean separation of concerns using WordPress hooks
- **Conditional Loading**: Assets only load when needed (shortcode/block present)

### Code Quality Standards
- **Data Sanitization**: All user inputs properly sanitized
- **Input Validation**: Comprehensive validation for form IDs and attributes
- **Translation Support**: Full i18n support with proper text domain
- **Error Handling**: Graceful degradation and user-friendly error messages
- **Documentation**: Complete PHPDoc and JSDoc documentation

### Technical Implementation
- **Modern PHP Syntax**: PHP 8.0+ features for better performance
- **Minimal user interaction**: Performance-optimized loading pattern
- **Responsive Design**: Mobile-first approach with viewport switching
- **External API Integration**: Clean integration with LeadGen App API
- **Block Editor Integration**: Native Gutenberg block with visual interface
- **Elementor Integration**: Custom widget with native Elementor interface
- **Namespace Organization**: Clean code organization using PHP namespaces

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

## Implemented Features

- [x] Basic plugin structure
- [x] Singleton pattern implementation
- [x] Shortcode with flexible parameters
- [x] Mobile device detection
- [x] JavaScript loading with optimization
- [x] Parameter validation and sanitization
- [x] Minimal user interaction pattern
- [x] Responsive viewport switching
- [x] CSS pulse animation placeholder
- [x] External script management
- [x] Error handling and debugging
- [x] Gutenberg block integration
- [x] Visual editor interface

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

### JavaScript API
```javascript
// Public API available for advanced integrations
window.LeadGenForm.loadForm("container-id");     // Manually load specific form
window.LeadGenForm.unloadForm("container-id");   // Unload and cleanup form
window.LeadGenForm.getLoadedForms();             // Get array of loaded form IDs
window.LeadGenForm.isFormLoaded("form-id");      // Check if specific form is loaded
window.LeadGenForm.reloadForm("container-id");   // Reload form (useful for dynamic content)
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
