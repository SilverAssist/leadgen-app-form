# LeadGen App Form Plugin - Release v1.0.4

## Package Information
- **Plugin Name**: LeadGen App Form Plugin
- **Version**: 1.0.4
- **File**: leadgen-app-form-v1.0.4.zip
- **Size**: ~53KB
- **Release Date**: July 28, 2025
- **License**: GPL v2 or later
- **Repository**: https://github.com/SilverAssist/leadgen-app-form

## New in v1.0.3 - Advanced Height Controls
🎨 **Major Enhancement**: Professional UI controls for height customization with enhanced user experience

### Key Features Added
- **Professional Height Controls**: Advanced UI with SelectControl for units and NumberControl/RangeControl inputs
- **Organized Control Panels**: Clean separation with dividers, headings, and logical grouping
- **Live Preview Enhancement**: Real-time preview showing configured heights in both Gutenberg and Elementor editors
- **Smart Shortcode Generation**: Intelligent shortcode output that only includes height attributes when they differ from defaults (600px/300px)
- **Enhanced Validation**: Range controls and NumberControl inputs prevent invalid height values automatically
- **Cross-Platform Consistency**: Identical functionality between Gutenberg blocks and Elementor widgets
- **Unit Flexibility**: Support for px, em, rem, vh, vw, and percentage units with clear descriptive labels

### Enhanced User Experience
- **Gutenberg Block Improvements**: Separate "Placeholder Height Settings" panel with professional controls
- **Elementor Widget Enhancements**: Organized controls with separators and visual grouping
- **Intelligent Defaults**: Height controls show meaningful defaults (600px desktop, 300px mobile)
- **Visual Feedback**: Live preview showing current height configuration in editor interfaces
- **Error Prevention**: Range validation prevents extreme values (1-2000 range)

### Technical Improvements
- **SelectControl Integration**: Professional unit selector with descriptive labels
- **RangeControl Implementation**: Smooth slider controls for precise height adjustment
- **NumberControl Addition**: Direct numeric input for Elementor widget precision
- **Smart Attribute Handling**: Only outputs height attributes when customized from defaults
- **Enhanced JavaScript**: Improved client-side validation with regex pattern matching
- **CSS Transitions**: Smooth height changes with 0.3s ease transitions for professional appearance

## Usage Examples

### Gutenberg Block Usage
1. **Add Block**: Search for "LeadGen Form" in block inserter
2. **Configure Form IDs**: Set desktop and mobile form IDs in main panel
3. **Customize Heights**: Open "Placeholder Height Settings" panel
4. **Select Unit**: Choose from px, em, rem, vh, vw, %
5. **Adjust Heights**: Use range sliders for precise control
6. **Live Preview**: See current configuration in block preview

### Elementor Widget Usage
1. **Drag Widget**: Add "LeadGen Form" widget to your page
2. **Set Form IDs**: Configure desktop and mobile IDs
3. **Height Configuration**: Use organized height controls section
4. **Unit Selection**: Professional dropdown for unit selection
5. **Numeric Input**: Direct input with validation
6. **Real-time Preview**: See configuration in editor preview

### Shortcode Examples
```php
// Smart generation - only includes customized heights
[leadgen_form desktop-id="form123" mobile-id="form456" desktop-height="800px" mobile-height="400px"]

// Default heights - clean shortcode
[leadgen_form desktop-id="form123" mobile-id="form456"]

// Viewport units
[leadgen_form desktop-id="form123" mobile-id="form456" desktop-height="50vh" mobile-height="40vh"]

// Percentage heights
[leadgen_form desktop-id="form123" mobile-id="form456" desktop-height="80%" mobile-height="60%"]
```

## System Requirements
- **WordPress**: 5.0 or higher
- **PHP**: 8.0 or higher
- **Browser Support**: Modern browsers with ES6 support
- **Optional**: Elementor 3.0+ for Elementor widget functionality

## Installation Instructions

### WordPress Admin (Recommended)
1. Download `leadgen-app-form-v1.0.4.zip`
2. Go to **Plugins → Add New → Upload Plugin**
3. Choose the ZIP file and click **Install Now**
4. Click **Activate Plugin**

### Manual Installation
1. Extract the ZIP file
2. Upload the `leadgen-app-form` folder to `/wp-content/plugins/`
3. Activate the plugin through WordPress admin

## Update Information
This plugin includes an **automatic update system** that checks for new versions via GitHub API:

- **Automatic Checks**: Every 12 hours in WordPress admin
- **Manual Checks**: Settings → LeadGen Forms → "Check for Updates"
- **One-Click Updates**: Standard WordPress update experience
- **Version Caching**: Intelligent caching to minimize API calls

## Upgrade Notes from v1.0.2
- **Enhanced UI**: Both Gutenberg and Elementor now have professional height controls
- **Better Organization**: Controls are logically grouped with clear visual separation
- **Smart Generation**: Shortcodes are optimized and only include necessary attributes
- **Improved Validation**: Range controls prevent invalid height values
- **Cross-Platform Parity**: Identical functionality between all integration methods
- **Backward Compatibility**: All existing shortcodes and blocks continue to work

## Features Included
- ✅ **NEW**: Professional Height Control UI (Gutenberg + Elementor)
- ✅ **NEW**: Smart Shortcode Generation with Optimization
- ✅ **NEW**: Enhanced Visual Organization with Separators and Headings
- ✅ **NEW**: Range and Number Controls for Precise Input
- ✅ **NEW**: Live Preview with Height Information Display
- ✅ **Updated**: Cross-Platform Consistency Between All Methods
- ✅ Automatic GitHub Update System
- ✅ WordPress Admin Settings Page
- ✅ Real-Time Update Status with AJAX
- ✅ GitHub Actions Release Automation
- ✅ Gutenberg Block Integration
- ✅ Elementor Widget Support
- ✅ Responsive Form Handling
- ✅ Modern PHP 8.0+ Features
- ✅ Translation Ready
- ✅ Performance Optimized
- ✅ ESLint Code Quality Standards
- ✅ GPL v2 Licensed

## Installation Package Contents
```
leadgen-app-form/
├── leadgen-app-form.php           # Main plugin file (Enhanced shortcode handling)
├── includes/                      # Additional PHP classes
│   ├── class-leadgen-form-block.php # Gutenberg block handler
│   ├── class-leadgen-app-form-updater.php # Custom GitHub update system
│   ├── class-leadgen-app-form-admin.php # WordPress admin interface
│   └── elementor/                 # Elementor integration
│       ├── class-widgets-loader.php # Elementor widgets loader
│       └── widgets/               # Elementor widgets
│           └── class-leadgen-form-widget.php # Enhanced LeadGen Form widget
├── blocks/                        # Gutenberg blocks
│   └── leadgen-form/              # Enhanced LeadGen form block
│       ├── block.json             # Updated block metadata with height attributes
│       ├── block.js               # Enhanced block JavaScript with height controls
│       └── editor.css             # Block editor styles
├── assets/
│   ├── css/                       # Styles with responsive design
│   │   ├── leadgen-app-form.css   # Main plugin styles with transitions
│   │   └── leadgen-elementor.css  # Elementor-specific styles
│   └── js/                        # Vanilla JS with responsive handling
│       ├── leadgen-app-form.js    # Enhanced frontend form loading with height support
│       └── leadgen-admin.js       # Admin update interface
├── README.md                      # Updated plugin documentation
├── CHANGELOG.md                   # Updated version change history
└── LICENSE                        # GPL v2 license
```

## Control Reference

### Gutenberg Block Controls
- **Main Panel**: "Form Configuration"
  - Desktop Form ID (TextControl)
  - Mobile Form ID (TextControl)
  - Information note
- **Height Panel**: "Placeholder Height Settings"
  - Height Unit (SelectControl): px, em, rem, vh, vw, %
  - Desktop Height (RangeControl): 1-2000, default 600
  - Mobile Height (RangeControl): 1-2000, default 300
  - Live preview with current values

### Elementor Widget Controls
- **Form Settings Section**:
  - Desktop Form ID (TextControl)
  - Mobile Form ID (TextControl)
  - Divider
  - Height Settings Heading
  - Height Unit (SelectControl): px, em, rem, vh, vw, %
  - Desktop Height (NumberControl): 1-2000, default 600
  - Mobile Height (NumberControl): 1-2000, default 300
  - Information note

## Support and Documentation
- **GitHub Repository**: https://github.com/SilverAssist/leadgen-app-form
- **Issues**: Report bugs and feature requests on GitHub
- **Documentation**: Complete usage guide in README.md
- **Changelog**: Full version history in CHANGELOG.md

## License
This plugin is licensed under the GPL v2 or later license. See LICENSE file for details.

---

**Release Package Generated**: July 28, 2025  
**Package Size**: ~49KB  
**GitHub Release**: v1.0.3
