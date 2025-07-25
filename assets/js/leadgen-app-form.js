/**
 * LeadGen App Form Plugin JavaScript
 *
 * Frontend functionality for the LeadGen App Form plugin.
 * Implements minimal user interaction patterns, responsive design,
 * and dynamic form loading inspired by Next.js component logic.
 *
 * @file leadgen-app-form.js
 * @version 1.0.0
 * @author Silver Assist
 * @requires jQuery
 * @since 1.0.0
 */

(function ($) {
  "use strict";

  /**
   * Global settings object destructuring
   * @type {Object}
   * @property {string} desktop_id - Desktop form ID (legacy, not used in current implementation)
   * @property {string} mobile_id - Mobile form ID (legacy, not used in current implementation) 
   * @property {string} base_form_url - Base URL for form scripts
   * @property {Array} instances - Array of shortcode instances from PHP
   */
  const {
    desktop_id: desktopId,
    mobile_id: mobileId,
    base_form_url: baseFormUrl = "https://forms.leadgenapp.io/js/lf.min.js/",
    instances = []
  } = window.leadGenAppSettings || {};

  /**
   * Current device type
   * @type {string}
   */
  let deviceType = "mobile";

  /**
   * Set of loaded script IDs to prevent duplicates
   * @type {Set<string>}
   */
  let loadedScripts = new Set();

  /**
   * Map of form containers and their configurations
   * @type {Map<string, Object>}
   */
  let formContainers = new Map();

  /**
   * Device type constants
   * @type {Object}
   * @property {string} mobile - Mobile device identifier
   * @property {string} desktop - Desktop device identifier
   */
  const DEVICE_TYPES = {
    mobile: "mobile",
    desktop: "desktop"
  };

  /**
   * Mobile breakpoint in pixels
   * @type {number}
   */
  const MOBILE_BREAKPOINT = 768;

  /**
   * Initialize when DOM is ready
   *
   * Entry point for the plugin functionality.
   * Sets up device type detection and initializes all form containers.
   *
   * @since 1.0.0
   * @listens jQuery#ready
   */
  $(document).ready(function () {
    initializeDeviceType();
    initializeLeadGenForms();
    setupViewportChangeHandler();
  });

  /**
   * Initialize device type detection
   *
   * Determines the current device type based on viewport width.
   * Sets the global deviceType variable.
   *
   * @since 1.0.0
   * @function
   */
  function initializeDeviceType() {
    deviceType = window.innerWidth < MOBILE_BREAKPOINT ? DEVICE_TYPES.mobile : DEVICE_TYPES.desktop;
  }

  /**
   * Initialize all LeadGen form containers
   *
   * Finds all form containers on the page and sets up their configuration.
   * Each container gets its own minimal user interaction setup.
   *
   * @since 1.0.0
   * @function
   */
  function initializeLeadGenForms() {
    $(".leadgen-form-container").each(function (index) {
      const $container = $(this);
      const containerDesktopId = $container.data("desktop-id");
      const containerMobileId = $container.data("mobile-id");

      /**
       * Configuration object for form container
       * @type {Object}
       * @property {jQuery} container - jQuery object of the container element
       * @property {string} desktopId - Desktop form ID
       * @property {string} mobileId - Mobile form ID
       * @property {string|null} currentId - Currently active form ID
       * @property {boolean} isLoaded - Whether the form script is loaded
       * @property {boolean} hasInteracted - Whether user has interacted
       */
      const config = {
        container: $container,
        desktopId: containerDesktopId,
        mobileId: containerMobileId,
        currentId: getCurrentFormId(containerDesktopId, containerMobileId),
        isLoaded: false,
        hasInteracted: false
      };

      formContainers.set($container.attr("id") || `form-${index}`, config);

      // Debug logging
      console.log("LeadGen Form initialized:", {
        desktopId: containerDesktopId,
        mobileId: containerMobileId,
        currentId: config.currentId,
        deviceType: deviceType
      });

      // Set up minimal user interaction
      setupMinimalUserInteraction(config);
    });
  }

  /**
   * Get current form ID based on device type
   *
   * Determines which form ID to use based on the current device type
   * and available IDs. Implements intelligent fallback logic.
   *
   * @since 1.0.0
   * @function
   * @param {string} desktopId - The desktop form ID
   * @param {string} mobileId - The mobile form ID
   * @returns {string|null} The appropriate form ID or null if none available
   */
  function getCurrentFormId(desktopId, mobileId) {
    if (deviceType === DEVICE_TYPES.mobile && mobileId) {
      return mobileId;
    } else if (desktopId) {
      return desktopId;
    } else if (mobileId) {
      return mobileId; // Fallback to mobile if no desktop
    }
    return null;
  }

  /**
   * Set up minimal user interaction for a form container
   *
   * Implements the minimal user interaction pattern where forms only load
   * after user interaction (focus, mousemove, scroll, or touchstart).
   * This improves initial page load performance.
   *
   * @since 1.0.0
   * @function
   * @param {Object} config - The form container configuration object
   * @param {jQuery} config.container - Container jQuery object
   * @param {string} config.currentId - Current form ID
   * @param {boolean} config.hasInteracted - Interaction status
   */
  function setupMinimalUserInteraction(config) {
    if (!config.currentId) {
      console.warn("No form ID available for container");
      return;
    }

    /**
     * Load form once on first interaction
     * @function
     */
    const loadFormOnce = () => {
      if (!config.hasInteracted) {
        config.hasInteracted = true;
        loadLeadGenForm(config);
      }
    };

    // Event listeners for minimal interaction pattern
    document.addEventListener("focus", loadFormOnce, { once: true });
    document.addEventListener("mousemove", loadFormOnce, { once: true });
    document.addEventListener("scroll", loadFormOnce, { once: true });
    document.addEventListener("touchstart", loadFormOnce, { once: true });

    // For debugging - immediate load in development
    // setTimeout(loadFormOnce, 100);
  }

  /**
   * Load specific LeadGen form
   *
   * Creates form markup, inserts it into the container, and loads the external script.
   * Handles the transition from placeholder to actual form content.
   *
   * @since 1.0.0
   * @function
   * @param {Object} config - Form configuration object
   * @param {string} config.currentId - Current form ID to load
   * @param {jQuery} config.container - Container jQuery object
   * @param {boolean} config.isLoaded - Load status flag
   */
  function loadLeadGenForm(config) {
    const { currentId, container } = config;

    if (!currentId || config.isLoaded) {
      return;
    }

    console.log("Loading LeadGen form:", currentId);

    // Create form markup
    const formMarkup = `
            <div id="leadgen-form-wrap-${currentId}" class="leadgen-form-content">
                <leadgen-form-${currentId}></leadgen-form-${currentId}>
            </div>
        `;

    // Insert markup into container
    const $formWrapper = container.find(".leadgen-form-wrapper");
    const $formContent = $formWrapper.find(".leadgen-form-content");

    if ($formContent.length === 0) {
      $formWrapper.append(formMarkup);
    } else {
      $formContent.html(`<leadgen-form-${currentId}></leadgen-form-${currentId}>`);
      $formContent.attr("id", `leadgen-form-wrap-${currentId}`);
    }

    // Load form script
    loadFormScript(currentId, () => {
      // Callback when script loads
      config.isLoaded = true;

      // Hide placeholder and show form
      container.addClass("loaded");

      console.log("LeadGen form loaded successfully:", currentId);
    });
  }

  /**
   * Load external form script
   *
   * Dynamically loads the external JavaScript for a specific form.
   * Prevents duplicate script loading and handles success/error callbacks.
   *
   * @since 1.0.0
   * @function
   * @param {string} formId - The form ID to load
   * @param {Function} [onLoadCallback] - Callback function to execute on successful load
   */
  function loadFormScript(formId, onLoadCallback) {
    const scriptId = `leadgen-script-${formId}`;

    // If already loaded, execute callback
    if (loadedScripts.has(scriptId)) {
      if (onLoadCallback) onLoadCallback();
      return;
    }

    // If script already exists in DOM, don't duplicate
    if (document.getElementById(scriptId)) {
      loadedScripts.add(scriptId);
      if (onLoadCallback) onLoadCallback();
      return;
    }

    // Create and load script
    const script = document.createElement("script");
    script.id = scriptId;
    script.src = `${baseFormUrl}${formId}`;
    script.async = true;

    script.onload = () => {
      loadedScripts.add(scriptId);
      if (onLoadCallback) onLoadCallback();
    };

    script.onerror = () => {
      console.error("Failed to load LeadGen form script:", formId);
    };

    document.body.appendChild(script);
  }

  /**
   * Unload form script
   *
   * Removes a form script from the DOM and cleans up tracking.
   * Used when switching between desktop and mobile forms.
   *
   * @since 1.0.0
   * @function
   * @param {string} formId - The form ID to unload
   */
  function unloadFormScript(formId) {
    const scriptId = `leadgen-script-${formId}`;
    const existingScript = document.getElementById(scriptId);

    if (existingScript) {
      document.body.removeChild(existingScript);
      loadedScripts.delete(scriptId);
    }
  }

  /**
   * Set up viewport change handler
   *
   * Registers a debounced resize event listener to handle responsive
   * form switching when the viewport size changes.
   *
   * @since 1.0.0
   * @function
   */
  function setupViewportChangeHandler() {
    $(window).on("resize.leadgen", debounce(handleViewportChange, 300));
  }

  /**
   * Handle viewport changes
   *
   * Detects device type changes and updates all form containers accordingly.
   * Unloads old scripts and sets up new minimal user interaction when needed.
   *
   * @since 1.0.0
   * @function
   */
  function handleViewportChange() {
    const newDeviceType = window.innerWidth < MOBILE_BREAKPOINT ? DEVICE_TYPES.mobile : DEVICE_TYPES.desktop;

    if (newDeviceType !== deviceType) {
      deviceType = newDeviceType;

      // Update all form containers
      formContainers.forEach((config, containerId) => {
        const newCurrentId = getCurrentFormId(config.desktopId, config.mobileId);

        if (newCurrentId !== config.currentId) {
          // Unload previous script if exists
          if (config.currentId && config.isLoaded) {
            unloadFormScript(config.currentId);
          }

          // Update configuration
          config.currentId = newCurrentId;
          config.isLoaded = false;
          config.hasInteracted = false;

          // Reset UI
          config.container.removeClass("loaded");

          // Reconfigure interaction
          if (newCurrentId) {
            setupMinimalUserInteraction(config);
          }

          console.log("Viewport changed, updated form:", {
            containerId,
            newDeviceType,
            newCurrentId
          });
        }
      });
    }
  }

  /**
   * Debounce function for optimizing events
   *
   * Limits the rate at which a function can fire. Useful for resize
   * events and other high-frequency events to improve performance.
   *
   * @since 1.0.0
   * @function
   * @param {Function} func - The function to debounce
   * @param {number} wait - The number of milliseconds to delay
   * @returns {Function} The debounced function
   */
  function debounce(func, wait) {
    let timeout;
    return function executedFunction() {
      const context = this;
      const args = arguments;
      const later = function () {
        timeout = null;
        func.apply(context, args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }

  /**
   * Public API for manual form control
   *
   * Exposes methods for external control of forms, useful for debugging
   * and advanced integrations.
   *
   * @since 1.0.0
   * @namespace
   * @global
   */
  window.LeadGenForm = {
    /**
     * Manually load a form by container ID
     *
     * @function
     * @param {string} containerId - The container ID to load
     * @returns {void}
     */
    loadForm: function (containerId) {
      const config = formContainers.get(containerId);
      if (config && config.currentId) {
        config.hasInteracted = true;
        loadLeadGenForm(config);
      }
    },

    /**
     * Unload a form by container ID
     *
     * @function
     * @param {string} containerId - The container ID to unload
     * @returns {void}
     */
    unloadForm: function (containerId) {
      const config = formContainers.get(containerId);
      if (config && config.currentId && config.isLoaded) {
        unloadFormScript(config.currentId);
        config.isLoaded = false;
        config.container.removeClass("loaded");
      }
    },

    /**
     * Get array of currently loaded form script IDs
     *
     * @function
     * @returns {string[]} Array of loaded script IDs
     */
    getLoadedForms: function () {
      return Array.from(loadedScripts);
    }
  };

})(jQuery);
