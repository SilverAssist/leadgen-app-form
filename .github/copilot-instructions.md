# LeadGen App Form — Project Context

WordPress plugin for embedding LeadGen App forms via shortcode, Gutenberg block, or Elementor widget with responsive desktop/mobile form switching.

## Plugin Info

| Key              | Value                          |
|------------------|--------------------------------|
| Namespace        | `LeadGenAppForm`               |
| Text Domain      | `leadgen-app-form`             |
| Version          | 1.0.3                         |
| Requires PHP     | 8.0                           |
| License          | Polyform Noncommercial 1.0.0  |
| GitHub Repo      | `SilverAssist/leadgen-app-form`|

## Differences from Global Standards

- **Double quotes** everywhere (PHP and JS) — not single quotes
- **PHP 8.0** minimum — not 8.2
- **Singleton pattern** (`get_instance()`) — not LoadableInterface
- **No activation/deactivation hooks** — plugin doesn't modify WP internals
- PSR-4 autoloading via `require_once` in `load_dependencies()`, not a DI container

## Architecture

```
leadgen-app-form.php              # Entry point (Singleton)
includes/
├── LeadGenFormBlock.php          # Gutenberg block handler
├── LeadGenAppFormUpdater.php     # GitHub updater (extends silverassist/wp-github-updater)
├── LeadGenAppFormAdmin.php       # Admin interface (Settings → LeadGen Forms)
└── elementor/
    ├── WidgetsLoader.php         # Conditional loader (only when Elementor active)
    └── widgets/
        └── LeadGenFormWidget.php # Elementor widget
blocks/leadgen-form/              # Gutenberg block assets (block.json, block.js, editor.css)
assets/css/                       # leadgen-app-form.css, leadgen-elementor.css
assets/js/                        # leadgen-app-form.js (frontend), leadgen-admin.js (admin AJAX)
```

### Namespaces

- `LeadGenAppForm` — main plugin classes
- `LeadGenAppForm\Block` — Gutenberg block
- `LeadGenAppForm\Elementor` — Elementor loader
- `LeadGenAppForm\Elementor\Widgets` — Elementor widgets

### Form Integration Methods

```php
// Shortcode (supports desktop-height / mobile-height since v1.0.3)
[leadgen_form desktop-id="uuid" mobile-id="uuid" desktop-height="800px" mobile-height="400px"]

// Gutenberg Block — search "LeadGen Form" in block inserter
// Elementor Widget — drag from "LeadGen Forms" category
```

### Form Loading Flow

1. PHP renders placeholder with pulse animation
2. JS waits for user interaction (focus/mousemove/scroll/touchstart)
3. Loads `https://forms.leadgenapp.io/js/lf.min.js/{id}` dynamically
4. Injects `<leadgen-form-{id}>` custom element
5. Switches desktop/mobile form at 768px breakpoint

### Update System

Uses `silverassist/wp-github-updater` package. `LeadGenAppFormUpdater` extends `GitHubUpdater` with plugin-specific config (asset pattern, 12h cache, AJAX action `leadgen_check_version`). Updates show in standard WP admin.

### Elementor Integration

- Conditional loading: `\did_action('elementor/loaded')`
- Widget category: `leadgen-forms`
- Hooks: `elementor/widgets/register`, `elementor/elements/categories_registered`
- Renders via same `render_shortcode()` method as the shortcode

## Quick Reference

| File | Role |
|------|------|
| `leadgen-app-form.php` | Main plugin file (Singleton) |
| `includes/LeadGenFormBlock.php` | Gutenberg block handler |
| `includes/LeadGenAppFormUpdater.php` | GitHub updater |
| `includes/LeadGenAppFormAdmin.php` | Admin settings page |
| `includes/elementor/WidgetsLoader.php` | Elementor widgets manager |
| `includes/elementor/widgets/LeadGenFormWidget.php` | LeadGen Form widget |
| `assets/js/leadgen-app-form.js` | Frontend form loading (Vanilla JS + jQuery) |
| `assets/js/leadgen-admin.js` | Admin AJAX update checking |
| `assets/css/leadgen-app-form.css` | Main styles + animations |
| `assets/css/leadgen-elementor.css` | Elementor-specific styles |
