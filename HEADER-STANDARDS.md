# LeadGen App Form Plugin - Header Standards

## Plugin Base Information

```
Plugin Name: LeadGen App Form Plugin
Plugin URI: http://silverassist.com/leadgen-app-form
Description: WordPress plugin that adds a shortcode to display forms with desktop-id and mobile-id parameters.
Version: 1.0.1
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
 * Version: 1.0.1
 * Author: Silver Assist
 * Author URI: http://silverassist.com/
 * Text Domain: leadgen-app-form
 * Domain Path: /languages
 * Requires PHP: 8.0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package LeadGenAppForm
 * @version 1.0.1
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
 * @version 1.0.1
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
 * @version 1.0.1
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
 * @version 1.0.1
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
 * @version 1.0.1
 */
```

### Example for class-leadgen-app-form-updater.php (New in v1.0.1):
```php
/**
 * LeadGen App Form Updater - Custom GitHub Updates Handler
 *
 * Handles automatic updates from public GitHub releases for the LeadGen App Form Plugin.
 * Provides seamless WordPress admin updates without requiring authentication tokens.
 *
 * @package LeadGenAppForm
 * @since 1.0.1
 * @author Silver Assist
 * @version 1.0.1
 */
```

### Example for class-leadgen-app-form-admin.php (New in v1.0.1):
```php
/**
 * LeadGen App Form Admin Page - Plugin Settings and Update Status
 *
 * Provides admin interface for plugin settings and update status display.
 * Shows current version, available updates, and manual update check functionality.
 *
 * @package LeadGenAppForm
 * @since 1.0.1
 * @author Silver Assist
 * @version 1.0.1
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
 * @version 1.0.1
 */
```

### Example for leadgen-admin.js (New in v1.0.1):
```javascript
/**
 * LeadGen App Form Admin JavaScript - Update Status Handler
 *
 * Handles AJAX requests for checking plugin updates manually and displaying
 * real-time update status in the WordPress admin interface.
 *
 * @file leadgen-admin.js
 * @version 1.0.1
 * @author Silver Assist
 * @requires jQuery
 * @since 1.0.1
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
 * @version 1.0.1
 * @author Silver Assist
 * @requires jQuery
 * @since 1.0.0
 */
```

## Important Notes

1. **Mandatory description**: All files must include a clear description of their content and functionality.

2. **Version consistency**: Maintain current version (1.0.1) in @version across all files.

3. **Proper namespace**: PHP files must include correct namespace according to their location (LeadGenAppForm, LeadGenAppForm\Elementor, etc.).

4. **Updated copyright**: Use year 2025 in CSS files.

5. **Author consistency**: Always use "Silver Assist" as author.

6. **License uniformity**: Maintain "GPL v2 or later" in all applicable files.

7. **Versioning standards**:
   - **@since**: Indicates when the file/feature was first introduced (never changes retroactively)
   - **@version**: Indicates current version of the file (updates with each release)
   - **New files in v1.0.1**: Use both `@since 1.0.1` and `@version 1.0.1`
   - **Existing files**: Keep original `@since`, update `@version` to current release

8. **Update system files**: New files introduced in v1.0.1 for automatic updates:
   - `class-leadgen-app-form-updater.php`
   - `class-leadgen-app-form-admin.php`
   - `leadgen-admin.js`
