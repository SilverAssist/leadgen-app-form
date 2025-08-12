# LeadGen App Form Plugin

WordPress plugin that adds a shortcode to display forms with different configurations for desktop and mobile devices.

## Features

- **📱 Responsive Forms**: Automatically switches between desktop and mobile form configurations based on device type
- **🎨 Advanced Height Controls**: Customize form placeholder heights with support for multiple units (px, em, rem, vh, vw, %)
- **🧩 Gutenberg Block Integration**: Visual block editor with intuitive sidebar controls and live preview
- **⚡ Elementor Widget Support**: Native Elementor widget with drag-and-drop functionality and styling options
- **📝 Flexible Shortcode**: Simple `[leadgen_form]` shortcode for direct content integration
- **🔄 Automatic Updates**: Built-in update system that keeps your plugin current automatically
- **⚙️ Easy Configuration**: Multiple integration methods - choose what works best for your workflow
- **🎯 Smart Loading**: Performance-optimized with minimal user interaction pattern
- **📐 Custom Dimensions**: Set different heights for desktop and mobile devices
- **🌐 Translation Ready**: Full internationalization support for multilingual sites
- **🛡️ Reliable Performance**: Graceful fallbacks and error handling for seamless user experience

## Requirements

- WordPress 5.0 or higher
- PHP 8.0 or higher

## Download

The plugin is available as a ready-to-install ZIP file:
- **File**: `leadgen-app-form-v1.0.5.zip` (~182KB)
- **Version**: 1.0.5
- **Compatibility**: WordPress 5.0+ with PHP 8.0+
- **Features**: Includes optimized Composer dependencies for automatic updates
- **New in v1.0.5**: Modular update system using silverassist/wp-github-updater package

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

## Plugin Structure

```
leadgen-app-form/
├── leadgen-app-form.php           # Main plugin file (Singleton pattern)
├── includes/                      # PSR-4 compliant PHP classes
│   ├── LeadGenFormBlock.php          # Gutenberg block handler
│   ├── LeadGenAppFormUpdater.php     # GitHub updater (using silverassist/wp-github-updater)
│   ├── LeadGenAppFormAdmin.php       # WordPress admin interface
│   └── elementor/                 # Elementor integration
│       ├── WidgetsLoader.php         # Elementor widgets loader
│       └── widgets/               # Elementor widgets
│           └── LeadGenFormWidget.php # LeadGen Form widget
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
├── vendor/                        # Composer dependencies (production)
│   ├── autoload.php              # Composer autoloader
│   └── silverassist/             # Silver Assist packages
│       └── wp-github-updater/    # Reusable GitHub updater package
├── .gitattributes                # Git attributes for proper exports
├── composer.json                 # Composer package configuration
├── README.md                     # Plugin documentation
├── CHANGELOG.md                  # Version change history
└── LICENSE                       # GPL v2 license
```

## JavaScript API

For advanced integrations, the plugin provides a JavaScript API:

```javascript
// Public API available for advanced integrations
window.LeadGenForm.loadForm("container-id");     // Manually load specific form
window.LeadGenForm.unloadForm("container-id");   // Unload and cleanup form
window.LeadGenForm.getLoadedForms();             // Get array of loaded form IDs
window.LeadGenForm.isFormLoaded("form-id");      // Check if specific form is loaded
window.LeadGenForm.reloadForm("container-id");   // Reload form (useful for dynamic content)
```

## 📋 Support & Documentation

### Documentation Files
- **User Guide**: This README.md
- **Change History**: [CHANGELOG.md](CHANGELOG.md)
- **Update System**: [UPDATE-SYSTEM.md](UPDATE-SYSTEM.md)

### Support
- **Issues**: [GitHub Issues](https://github.com/SilverAssist/leadgen-app-form/issues)
- **Releases**: [GitHub Releases](https://github.com/SilverAssist/leadgen-app-form/releases)
- **Repository**: [GitHub Repository](https://github.com/SilverAssist/leadgen-app-form)

## 📄 License

This plugin is licensed under the GPL v2 or later.

---

**Made with ❤️ by [Silver Assist](https://silverassist.com)**
