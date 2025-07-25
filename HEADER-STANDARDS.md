# LeadGen App Form Plugin - Header Standards

## Plugin Base Information

```
Plugin Name: LeadGen App Form Plugin
Plugin URI: http://silverassist.com/leadgen-app-form
Description: WordPress plugin that adds a shortcode to display forms with desktop-id and mobile-id parameters.
Version: 1.0.0
Author: Silver Assist
Author URI: http://silverassist.com/
Text Domain: leadgen-app-form
Domain Path: /languages
Requires PHP: 8.0
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
```

## Header Standards by File Type

### 1. PHP Files

#### Main Plugin File:
```php
<?php
/**
 * Plugin Name: LeadGen App Form Plugin
 * Plugin URI: http://silverassist.com/leadgen-app-form
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
 * @version 1.0.0
 * @since 1.0.0
 * @author Silver Assist
 */
```

#### PHP Class/Functionality Files:
```php
<?php
/**
 * [File Name] - [Brief Description]
 *
 * [Detailed description of file functionality]
 *
 * @package LeadGenAppForm[/SubNamespace if applicable]
 * @version 1.0.0
 * @since 1.0.0
 * @author Silver Assist
 */
```

### 2. CSS Files

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

### 3. JavaScript Files

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

## Specific Examples

### Example for class-widgets-loader.php:
```php
/**
 * LeadGen App Form Plugin - Elementor Widgets Loader
 *
 * This class handles the registration and loading of Elementor widgets
 * for the LeadGen App Form plugin. It ensures widgets are only loaded
 * when Elementor is active and provides proper integration.
 *
 * @package LeadGenAppForm\Elementor
 * @since 1.0.0
 * @author Silver Assist
 */
```

### Example for leadgen-app-form.css:
```css
/**
 * LeadGen App Form Plugin - Main Styles
 *
 * Core styles for the LeadGen App Form plugin including form containers,
 * loading animations, responsive design, and error states.
 *
 * @package LeadGenAppForm
 * @since 1.0.0
 * @author Silver Assist
 * @copyright Copyright (c) 2025, Silver Assist
 * @license GPL v2 or later
 * @version 1.0.0
 */
```

### Example for leadgen-app-form.js (when it exists):
```javascript
/**
 * LeadGen App Form Plugin - Frontend Scripts
 *
 * JavaScript functionality for form loading, validation, and user interactions
 * in the LeadGen App Form plugin.
 *
 * @file leadgen-app-form.js
 * @version 1.0.0
 * @author Silver Assist
 * @requires jQuery
 * @since 1.0.0
 */
```

## Development Commands

### Plugin Testing
```bash
# Activate plugin via WP-CLI
wp plugin activate leadgen-app-form

# Check for PHP syntax errors (main files)
php -l leadgen-app-form.php
php -l includes/elementor/class-widgets-loader.php
php -l includes/elementor/widgets/class-leadgen-form-widget.php

# Validate JavaScript with ESLint (if ESLint is installed globally)
eslint assets/js/leadgen-app-form.js
eslint blocks/leadgen-form/block.js

# Test Elementor integration (requires Elementor plugin active)
wp eval "if (class_exists('\\Elementor\\Plugin')) { echo 'Elementor is active'; } else { echo 'Elementor not found'; }"
```

### Code Quality
- **ESLint Configuration**: `.eslintrc.json` configured for WordPress development
- **JavaScript Standards**: Double quotes, semicolons, 2-space indentation
- **WordPress Globals**: `wp`, `jQuery`, `leadGenAppSettings` pre-configured
- **IDE Integration**: Most IDEs will automatically detect and use ESLint configuration

## Important Notes

1. **Mandatory description**: All files must include a clear description of their content and functionality.

2. **Version consistency**: Maintain version 1.0.0 in all files until next release.

3. **Proper namespace**: PHP files must include correct namespace according to their location (LeadGenAppForm, LeadGenAppForm\Elementor, etc.).

4. **Updated copyright**: Use year 2025 in CSS files.

5. **Author consistency**: Always use "Silver Assist" as author.

6. **License uniformity**: Maintain "GPL v2 or later" in all applicable files.
