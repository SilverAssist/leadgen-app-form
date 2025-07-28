/**
 * LeadGen App Form Plugin - Gutenberg Block
 *
 * WordPress Gutenberg block for inserting LeadGen forms with desktop and mobile configurations.
 * Provides an intuitive interface for users to configure form IDs directly in the editor.
 *
 * @file block.js
 * @version 1.0.1
 * @author Silver Assist
 * @requires wp.blocks, wp.element, wp.components, wp.i18n, wp.blockEditor
 * @since 1.0.0
 */

(function (blocks, element, components, i18n, blockEditor) {
  "use strict";

  const { registerBlockType } = blocks;
  const { createElement: el, Fragment } = element;
  const {
    TextControl,
    PanelBody,
    Placeholder,
    Icon
  } = components;
  const { __ } = i18n;
  const { InspectorControls, useBlockProps } = blockEditor;

  /**
   * Custom icon for the LeadGen Form block
   */
  const leadGepIcon = el("svg", {
    width: 24,
    height: 24,
    viewBox: "0 0 24 24",
    fill: "none",
    xmlns: "http://www.w3.org/2000/svg"
  },
    el("path", {
      d: "M20 6H4C2.89 6 2 6.89 2 8V16C2 17.11 2.89 18 4 18H20C21.11 18 22 17.11 22 16V8C22 6.89 21.11 6 20 6ZM20 16H4V8H20V16ZM6 10H18V12H6V10ZM6 14H14V16H6V14Z",
      fill: "currentColor"
    })
  );

  /**
   * Register the LeadGen Form block
   */
  registerBlockType("leadgen/form-block", {
    title: __("LeadGen Form", "leadgen-app-form"),
    description: __("Insert a responsive LeadGen form with desktop and mobile configurations.", "leadgen-app-form"),
    icon: leadGepIcon,
    category: "widgets",
    keywords: [
      __("form", "leadgen-app-form"),
      __("leadgen", "leadgen-app-form"),
      __("lead generation", "leadgen-app-form"),
      __("responsive", "leadgen-app-form")
    ],

    attributes: {
      desktopId: {
        type: "string",
        default: ""
      },
      mobileId: {
        type: "string",
        default: ""
      }
    },

    supports: {
      html: false,
      align: ["wide", "full"],
      spacing: {
        margin: true,
        padding: true
      }
    },

    /**
     * Edit function - renders the block in the editor
     *
     * @param {Object} props Block properties
     * @returns {Element} React element
     */
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { desktopId, mobileId } = attributes;
      const blockProps = useBlockProps();

      /**
       * Update desktop ID attribute
       *
       * @param {string} value New desktop ID
       */
      const onChangeDesktopId = function (value) {
        setAttributes({ desktopId: value });
      };

      /**
       * Update mobile ID attribute
       *
       * @param {string} value New mobile ID
       */
      const onChangeMobileId = function (value) {
        setAttributes({ mobileId: value });
      };

      /**
       * Generate preview text based on current attributes
       *
       * @returns {string} Preview text
       */
      const getPreviewText = function () {
        const hasDesktop = desktopId.trim() !== "";
        const hasMobile = mobileId.trim() !== "";

        if (hasDesktop && hasMobile) {
          return __("LeadGen Form (Desktop + Mobile)", "leadgen-app-form");
        } else if (hasDesktop) {
          return __("LeadGen Form (Desktop Only)", "leadgen-app-form");
        } else if (hasMobile) {
          return __("LeadGen Form (Mobile Only)", "leadgen-app-form");
        } else {
          return __("LeadGen Form (Not Configured)", "leadgen-app-form");
        }
      };

      /**
       * Check if block has valid configuration
       *
       * @returns {boolean} True if at least one ID is configured
       */
      const isValidConfiguration = function () {
        return desktopId.trim() !== "" || mobileId.trim() !== "";
      };

      return el(Fragment, {},
        // Inspector Controls (Sidebar)
        el(InspectorControls, {},
          el(PanelBody, {
            title: __("Form Configuration", "leadgen-app-form"),
            initialOpen: true
          },
            el(TextControl, {
              label: __("Desktop Form ID", "leadgen-app-form"),
              help: __("Form ID to display on desktop devices", "leadgen-app-form"),
              value: desktopId,
              onChange: onChangeDesktopId,
              placeholder: __("Enter desktop form ID...", "leadgen-app-form")
            }),
            el(TextControl, {
              label: __("Mobile Form ID", "leadgen-app-form"),
              help: __("Form ID to display on mobile devices", "leadgen-app-form"),
              value: mobileId,
              onChange: onChangeMobileId,
              placeholder: __("Enter mobile form ID...", "leadgen-app-form")
            }),
            el("p", {
              style: {
                fontSize: "12px",
                fontStyle: "italic",
                marginTop: "10px",
                color: "#666"
              }
            }, __("At least one form ID is required. If only one ID is provided, it will be used for all devices.", "leadgen-app-form"))
          )
        ),

        // Block Content
        el("div", blockProps,
          el(Placeholder, {
            icon: leadGepIcon,
            label: getPreviewText(),
            instructions: isValidConfiguration()
              ? __("Form is configured and ready. Use the sidebar to modify settings.", "leadgen-app-form")
              : __("Configure your form IDs in the sidebar to get started.", "leadgen-app-form"),
            className: isValidConfiguration() ? "is-configured" : "needs-configuration"
          },
            // Configuration summary
            isValidConfiguration() && el("div", {
              style: {
                marginTop: "15px",
                padding: "10px",
                backgroundColor: "#f8f9fa",
                borderRadius: "4px",
                fontSize: "13px"
              }
            },
              desktopId && el("div", {},
                el("strong", {}, __("Desktop:", "leadgen-app-form")), " ", desktopId
              ),
              mobileId && el("div", {},
                el("strong", {}, __("Mobile:", "leadgen-app-form")), " ", mobileId
              )
            )
          )
        )
      );
    },

    /**
     * Save function - renders the shortcode output
     *
     * @param {Object} props Block properties
     * @returns {Element} React element with shortcode
     */
    save: function (props) {
      const { attributes } = props;
      const { desktopId, mobileId } = attributes;

      // Don't render if no IDs are configured
      if (!desktopId.trim() && !mobileId.trim()) {
        return null;
      }

      // Build shortcode attributes
      let shortcodeAtts = [];

      if (desktopId.trim()) {
        shortcodeAtts.push(`desktop-id="${desktopId.trim()}"`);
      }

      if (mobileId.trim()) {
        shortcodeAtts.push(`mobile-id="${mobileId.trim()}"`);
      }

      const shortcode = `[leadgen_form ${shortcodeAtts.join(" ")}]`;

      return el("div", useBlockProps.save(), shortcode);
    }
  });

})(
  window.wp.blocks,
  window.wp.element,
  window.wp.components,
  window.wp.i18n,
  window.wp.blockEditor
);
