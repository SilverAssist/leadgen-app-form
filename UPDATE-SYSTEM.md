# LeadGen App Form Plugin - Automatic Update System

## 🎉 **Automatic Updates from GitHub (Public Repository)**

Your plugin includes a professional automatic update system that connects directly to your **public** GitHub repository for seamless WordPress updates - no configuration required!

## ✅ **How It Works (Zero Configuration Required)**

- ✅ **No tokens or authentication needed** - public repository access
- ✅ **Automatic Update Checks** - WordPress checks for updates every 12 hours
- ✅ **GitHub Integration** - Downloads updates directly from GitHub releases
- ✅ **WordPress Native Experience** - Updates appear in standard WordPress plugins page
- ✅ **Admin Dashboard** - Dedicated settings page with update status
- ✅ **Manual Update Check** - Force check for updates anytime
- ✅ **Version Caching** - Efficient API usage with 12-hour cache
- ✅ **Error Handling** - Graceful handling of network and API errors

## 📋 How It Works

### 1. **Automatic Detection**
The system automatically detects when running in WordPress admin and initializes the updater.

### 2. **GitHub API Integration**
- Connects to `https://api.github.com/repos/SilverAssist/leadgen-app-form/releases/latest`
- Retrieves latest version information
- Compares with current installed version

### 3. **WordPress Integration**
- Hooks into WordPress update system
- Shows notifications in standard plugins page
- Provides "Update Now" functionality

### 4. **Download Process**
- Downloads ZIP file from GitHub release assets
- Uses format: `leadgen-app-form-v{version}.zip`
- Installs through WordPress standard update process

## 🛠️ Files Structure

```
includes/
├── class-leadgen-app-form-updater.php    # Core updater functionality
└── class-leadgen-app-form-admin.php      # Admin interface

assets/js/
└── leadgen-admin.js                      # Admin page JavaScript
```

## 📱 Admin Interface

### Access Location
```
WordPress Admin → Settings → LeadGen Forms
```

### Features Available
- **Current Version Display** - Shows installed version
- **Update Status** - Real-time update checking
- **Manual Check Button** - Force update check
- **GitHub Repository Link** - Direct link to source code
- **Usage Instructions** - How to use shortcodes, blocks, and widgets

## 🔧 Technical Implementation

### Update Check Process
```php
// Automatic check (every 12 hours)
add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_update']);

// Manual check via AJAX
add_action('wp_ajax_leadgen_check_version', [$this, 'manual_version_check']);
```

### Version Comparison
```php
if (version_compare($this->current_version, $remote_version, '<')) {
    // Update available - add to WordPress update transient
}
```

### Download URL Generation
```php
$download_url = "https://github.com/{$this->github_repo}/releases/download/v{$version}/leadgen-app-form-v{$version}.zip";
```

## 🎯 User Experience

### For End Users
1. **Notification** - See update notification in WordPress admin
2. **One-Click Update** - Click "Update Now" in plugins page
3. **Automatic Installation** - WordPress handles the update process
4. **Settings Preserved** - All plugin settings remain intact

### For Administrators
1. **Admin Dashboard** - Dedicated page showing update status
2. **Manual Control** - Force check for updates anytime
3. **Version History** - View current and available versions
4. **Direct Links** - Access to GitHub repository and documentation

## 🚨 Error Handling

### Network Issues
- Graceful degradation when GitHub API is unavailable
- Cached version information prevents repeated failed requests
- Clear error messages in admin interface

### Version Format
- Handles both `v1.0.0` and `1.0.0` tag formats
- Automatic version string sanitization
- Fallback to current version on parse errors

### Update Failures
- WordPress handles installation errors
- Plugin remains functional even if update fails
- Clear error messages for troubleshooting

## 🔄 Release Compatibility

### Required Release Format
The update system expects GitHub releases with:
- **Tag Format**: `v1.0.0` (or `1.0.0`)
- **Asset Name**: `leadgen-app-form-v1.0.0.zip`
- **Public Release**: Not draft or pre-release

### Automatic Compatibility
Works seamlessly with the existing GitHub Actions release automation:
- ✅ Compatible with `release.yml` workflow
- ✅ Uses same ZIP naming convention
- ✅ Reads version from same tag format

## 📊 Performance

### Caching Strategy
- **Version Cache**: 12 hours
- **Transient Storage**: WordPress database
- **API Rate Limits**: Respectful usage with caching

### Load Impact
- **Frontend**: Zero impact (admin-only functionality)
- **Admin**: Minimal impact with efficient caching
- **Updates**: Standard WordPress update process

## 🔐 Security

### WordPress Standards
- Uses WordPress nonces for AJAX requests
- Capability checks (`manage_options`)
- Sanitized input and escaped output

### GitHub Integration
- Read-only API access (no authentication required for public repos)
- HTTPS-only connections
- WordPress HTTP API for secure requests

## 🎉 Benefits

### For Plugin Development
- **Professional Experience** - Native WordPress update experience
- **Automated Process** - Works with existing release automation
- **Version Control** - Centralized version management
- **User Friendly** - Familiar WordPress interface

### For Plugin Users
- **Seamless Updates** - Just like any WordPress plugin
- **No Extra Steps** - No manual downloads or installations
- **Version Tracking** - Clear version information
- **Reliable Process** - Tested WordPress update mechanism

This system provides a professional, user-friendly update experience that integrates seamlessly with both your existing release automation and the WordPress ecosystem.
