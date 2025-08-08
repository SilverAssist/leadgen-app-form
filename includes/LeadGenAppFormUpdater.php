<?php

/**
 * LeadGen App Form Updater - GitHub Updates Integration
 *
 * Integrates the reusable silverassist/wp-github-updater package for automatic updates
 * from public GitHub releases. Provides seamless WordPress admin updates.
 *
 * @package LeadGenAppForm
 * @since 1.0.1
 * @author Silver Assist
 * @version 1.0.6
 */

namespace LeadGenAppForm;

// Prevent direct access
if (!defined("ABSPATH")) {
    exit;
}

use SilverAssist\WpGithubUpdater\Updater as GitHubUpdater;
use SilverAssist\WpGithubUpdater\UpdaterConfig;

/**
 * Class LeadGenAppFormUpdater
 * 
 * Extends the reusable GitHub updater package with LeadGen App Form specific configuration.
 * This approach reduces code duplication and centralizes update logic maintenance.
 */
class LeadGenAppFormUpdater extends GitHubUpdater
{
    /**
     * Initialize the LeadGen App Form updater with specific configuration
     *
     * @param string $plugin_file   Path to main plugin file
     * @param string $github_repo   GitHub repository (username/repository)
     */
    public function __construct(string $plugin_file, string $github_repo)
    {
        $config = new UpdaterConfig(
            $plugin_file,
            $github_repo,
            [
                "plugin_name" => "LeadGen App Form Plugin",
                "plugin_description" => "WordPress plugin that adds a shortcode to display LeadGen App forms with desktop-id and mobile-id parameters, featuring professional height controls and cross-platform integration.",
                "plugin_author" => "Silver Assist",
                "plugin_homepage" => "https://github.com/{$github_repo}",
                "requires_wordpress" => "6.5",
                "requires_php" => "8.0",
                "asset_pattern" => "leadgen-app-form-v{version}.zip",
                "cache_duration" => 12 * 3600, // 12 hours
                "ajax_action" => "leadgen_check_version",
                "ajax_nonce" => "leadgen_version_check"
            ]
        );

        parent::__construct($config);
    }
}
