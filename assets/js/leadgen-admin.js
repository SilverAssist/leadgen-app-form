/**
 * LeadGen App Form Admin JavaScript - Update Status Handler
 *
 * Handles AJAX requests for checking plugin updates manually and displaying
 * real-time update status in the WordPress admin interface.
 *
 * @file leadgen-admin.js
 * @version 1.0.4
 * @author Silver Assist
 * @requires jQuery
 * @since 1.0.1
 */

(function ($) {
  "use strict";

  $(document).ready(function () {
    // Check for updates on page load
    checkUpdatesStatus();

    // Manual update check button
    $("#check-updates").on("click", function () {
      checkUpdatesStatus(true);
    });
  });

  /**
   * Check for plugin updates
   * @param {boolean} manual Whether this is a manual check
   */
  function checkUpdatesStatus(manual = false) {
    const $statusDiv = $("#update-status");
    const $button = $("#check-updates");

    // Show loading state
    $statusDiv.html(`
            <span class="spinner is-active"></span>
            ${leadgenAdmin.strings.checking}
        `);

    $button.prop("disabled", true);

    // AJAX request to check updates
    $.ajax({
      url: leadgenAdmin.ajax_url,
      type: "POST",
      data: {
        action: "leadgen_check_version",
        nonce: leadgenAdmin.nonce,
        manual: manual ? 1 : 0
      },
      success: function (response) {
        if (response.success && response.data) {
          const data = response.data;

          if (data.has_update) {
            $statusDiv.html(`
                            <span class="dashicons dashicons-update update-available"></span>
                            <span class="update-available">${leadgenAdmin.strings.updateAvailable}</span>
                            <br>
                            <small>${data.message}</small>
                            <br>
                            <a href="${window.location.origin}/wp-admin/plugins.php" class="button button-primary" style="margin-top: 10px;">
                                ${manual ? "Go to Plugins Page" : "View Available Updates"}
                            </a>
                        `);
          } else {
            $statusDiv.html(`
                            <span class="dashicons dashicons-yes-alt update-current"></span>
                            <span class="update-current">${leadgenAdmin.strings.upToDate}</span>
                            <br>
                            <small>${data.message}</small>
                        `);
          }
        } else {
          $statusDiv.html(`
                        <span class="dashicons dashicons-warning" style="color: #d63638;"></span>
                        ${leadgenAdmin.strings.error}
                        <br>
                        <small>Please try again later or check your internet connection.</small>
                    `);
        }
      },
      error: function () {
        $statusDiv.html(`
                    <span class="dashicons dashicons-warning" style="color: #d63638;"></span>
                    ${leadgenAdmin.strings.error}
                    <br>
                    <small>Network error occurred. Please try again.</small>
                `);
      },
      complete: function () {
        $button.prop("disabled", false);
      }
    });
  }

})(jQuery);
