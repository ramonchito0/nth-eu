// ==== core/columns customizations ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/columns/register-attributes',
  (settings, name) => {
    if (name !== 'core/columns') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        stackOnTablet: { type: 'boolean', default: false },
        allowFullWidth: { type: 'boolean', default: false },
        reverseOnTablet: { type: 'boolean', default: false },
        reverseOnMobile: { type: 'boolean', default: false },
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/columns/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/columns') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options' },
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Stack on tablet',
              checked: !!attributes.stackOnTablet,
              onChange: (val) => setAttributes({ stackOnTablet: val }),
            }),
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Enable Full Width',
              checked: !!attributes.allowFullWidth,
              onChange: (val) => setAttributes({ allowFullWidth: val }),
            }),
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Reverse on Tablet',
              checked: !!attributes.reverseOnTablet,
              onChange: (val) => setAttributes({ reverseOnTablet: val }),
            }),
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Reverse on Mobile',
              checked: !!attributes.reverseOnMobile,
              onChange: (val) => setAttributes({ reverseOnMobile: val }),
            })
          )
        )
      );
    };
  }, 'withStackOnTabletToggle')
);

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/columns/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/columns') {
      if (attributes.stackOnTablet) {
        extraProps.className = (extraProps.className || '') + ' stack-on-tablet';
      }
      if (attributes.allowFullWidth) {
        extraProps.className = (extraProps.className || '') + ' w-full';
      }
      if (attributes.reverseOnTablet) {
        extraProps.className = (extraProps.className || '') + ' max-lg:flex-col-reverse';
      }
      if (attributes.reverseOnMobile) {
        extraProps.className = (extraProps.className || '') + ' max-md:flex-col-reverse';
      }
    }
    return extraProps;
  }
);

wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/columns/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/columns') {
        let cls = props.className || '';
        const atts = props.block.attributes;
        if (atts.stackOnTablet) cls += ' stack-on-tablet';
        if (atts.allowFullWidth) cls += ' w-full';
        if (atts.reverseOnTablet) cls += ' max-lg:flex-col-reverse';
        if (atts.reverseOnMobile) cls += ' max-md:flex-col-reverse';
        if (cls !== (props.className || '')) {
          return wp.element.createElement(BlockListBlock, { ...props, className: cls });
        }
      }
      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withStackOnTabletEditorClass')
);


// ==== core/group customizations ====

// ==== core/group customizations (with Grid mobile columns) ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/group/register-attributes',
  (settings, name) => {
    if (name !== 'core/group') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        allowFullWidth: { type: 'boolean', default: false },
        addMobileInnerPadding: { type: 'boolean', default: false },
        // NEW: mobile columns for Grid layout only
        ndsMobileCols: { type: 'number', default: 1 }, // 1–6
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/group/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/group') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;
      const isGrid = attributes?.layout && attributes.layout.type === 'grid';
      const colsVal = Math.max(1, Math.min(6, parseInt(attributes.ndsMobileCols, 10) || 1));

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options', initialOpen: true },
            // Existing toggles
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Enable Full Width',
              checked: !!attributes.allowFullWidth,
              onChange: (val) => setAttributes({ allowFullWidth: val }),
            }),
            // NEW: show only when Group is set to Grid layout
            isGrid &&
              wp.element.createElement(wp.components.SelectControl, {
                label: 'Mobile columns (1–6)',
                value: String(colsVal),
                options: [
                  { label: '1', value: '1' },
                  { label: '2', value: '2' },
                  { label: '3', value: '3' },
                  { label: '4', value: '4' },
                  { label: '5', value: '5' },
                  { label: '6', value: '6' },
                ],
                help: 'Applies on mobile as class nds-m-cols-N when this Group uses Grid layout.',
                onChange: (newVal) => {
                  const n = Math.max(1, Math.min(6, parseInt(newVal, 10) || 1));
                  setAttributes({ ndsMobileCols: n });
                },
              })
          )
        )
      );
    };
  }, 'withNdsGroupOptions')
);

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/group/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/group') {
      // keep your existing classes
      if (attributes.allowFullWidth) {
        extraProps.className = (extraProps.className || '') + ' w-full';
      }
      // NEW: add mobile cols class only if layout is Grid
      const isGrid = attributes?.layout && attributes.layout.type === 'grid';
      if (isGrid && attributes.ndsMobileCols) {
        const n = Math.max(1, Math.min(6, parseInt(attributes.ndsMobileCols, 10) || 1));
        extraProps.className = (extraProps.className || '') + ` nds-m-cols-${n}`;
      }
    }
    return extraProps;
  }
);

wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/group/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/group') {
        let cls = props.className || '';
        const atts = props.block.attributes;
        if (atts.allowFullWidth) cls += ' w-full';
        const isGrid = atts?.layout && atts.layout.type === 'grid';
        if (isGrid && atts.ndsMobileCols) {
          const n = Math.max(1, Math.min(6, parseInt(atts.ndsMobileCols, 10) || 1));
          cls += ` nds-m-cols-${n}`;
        }
        if (cls !== (props.className || '')) {
          return wp.element.createElement(BlockListBlock, { ...props, className: cls });
        }
      }
      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withNdsGroupEditorClass')
);

// ==== core/heading customizations ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/heading/register-attributes',
  (settings, name) => {
    if (name !== 'core/heading') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        topTabletMobileSpacing: { type: 'string', default: '' },
        bottomTabletMobileSpacing: { type: 'string', default: '' },
        tabletFontSize: { type: 'string', default: '' },
        mobileFontSize: { type: 'string', default: '' },
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/heading/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/heading') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;

      // Get font sizes from theme.json
      const fontSizeOptions = [
        { label: 'Default', value: '' },
        { label: 'Extra Small', value: 'xs' },
        { label: 'Small', value: 'sm' },
        { label: 'Base', value: 'base' },
        { label: 'Medium', value: 'md' },
        { label: 'Medium 2', value: 'md2' },
        { label: 'Medium 3', value: 'md3' },
        { label: 'Large', value: 'lg' },
        { label: '2XL', value: '2xl' },
        { label: '3XL', value: '3xl' },
      ];

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options', initialOpen: true },
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet & Mobile Top Spacing',
              value: attributes.topTabletMobileSpacing || '',
              options: [
                { label: 'Inherit', value: '' },
                { label: 'None', value: 'none' },
                { label: 'Extra Small', value: 'xs' },
                { label: 'Small', value: 'sm' },
                { label: 'Medium', value: 'md' },
                { label: 'Large', value: 'lg' },
              ],
              onChange: (val) => setAttributes({ topTabletMobileSpacing: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet & Mobile Bottom Spacing',
              value: attributes.bottomTabletMobileSpacing || '',
              options: [
                { label: 'Inherit', value: '' },
                { label: 'None', value: 'none' },
                { label: 'Extra Small', value: 'xs' },
                { label: 'Small', value: 'sm' },
                { label: 'Medium', value: 'md' },
                { label: 'Large', value: 'lg' },
              ],
              onChange: (val) => setAttributes({ bottomTabletMobileSpacing: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet Font Size',
              value: attributes.tabletFontSize || '',
              options: fontSizeOptions,
              onChange: (val) => setAttributes({ tabletFontSize: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Mobile Font Size',
              value: attributes.mobileFontSize || '',
              options: fontSizeOptions,
              onChange: (val) => setAttributes({ mobileFontSize: val }),
            })
          )
        )
      );
    };
  }, 'withNdsHeadingSpacing')
);

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/heading/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/heading') {
      if (attributes.topTabletMobileSpacing) {
        const className = attributes.topTabletMobileSpacing === 'none' 
          ? 'max-lg:!mt-0' 
          : `top-tb-mb-${attributes.topTabletMobileSpacing}`;
        extraProps.className = (extraProps.className || '') + ` ${className}`;
      }
      if (attributes.bottomTabletMobileSpacing) {
        const className = attributes.bottomTabletMobileSpacing === 'none' 
          ? 'max-lg:!mb-0' 
          : `bottom-tb-mb-${attributes.bottomTabletMobileSpacing}`;
        extraProps.className = (extraProps.className || '') + ` ${className}`;
      }
      if (attributes.tabletFontSize) {
        extraProps.className = (extraProps.className || '') + ` tb-font-${attributes.tabletFontSize}`;
      }
      if (attributes.mobileFontSize) {
        extraProps.className = (extraProps.className || '') + ` mb-font-${attributes.mobileFontSize}`;
      }
    }
    return extraProps;
  }
);

wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/heading/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/heading') {
        let cls = props.className || '';
        const atts = props.block.attributes;
        if (atts.topTabletMobileSpacing) {
          const className = atts.topTabletMobileSpacing === 'none' 
            ? 'max-lg:!mt-0' 
            : `top-tb-mb-${atts.topTabletMobileSpacing}`;
          cls += ` ${className}`;
        }
        if (atts.bottomTabletMobileSpacing) {
          const className = atts.bottomTabletMobileSpacing === 'none' 
            ? 'max-lg:!mb-0' 
            : `bottom-tb-mb-${atts.bottomTabletMobileSpacing}`;
          cls += ` ${className}`;
        }
        if (atts.tabletFontSize) cls += ` tb-font-${atts.tabletFontSize}`;
        if (atts.mobileFontSize) cls += ` mb-font-${atts.mobileFontSize}`;
        if (cls !== (props.className || '')) {
          return wp.element.createElement(BlockListBlock, { ...props, className: cls });
        }
      }
      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withNdsHeadingEditorClass')
);

// ==== core/paragraph customizations ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/paragraph/register-attributes',
  (settings, name) => {
    if (name !== 'core/paragraph') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        topTabletMobileSpacing: { type: 'string', default: '' },
        bottomTabletMobileSpacing: { type: 'string', default: '' },
        tabletFontSize: { type: 'string', default: '' },
        mobileFontSize: { type: 'string', default: '' },
        noUnderlineOnLink: { type: 'boolean', default: false },
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/paragraph/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/paragraph') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;

      // Get font sizes from theme.json
      const fontSizeOptions = [
        { label: 'Default', value: '' },
        { label: 'Extra Small', value: 'xs' },
        { label: 'Small', value: 'sm' },
        { label: 'Base', value: 'base' },
        { label: 'Medium', value: 'md' },
        { label: 'Medium 2', value: 'md2' },
        { label: 'Medium 3', value: 'md3' },
        { label: 'Large', value: 'lg' },
        { label: '2XL', value: '2xl' },
        { label: '3XL', value: '3xl' },
      ];

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options', initialOpen: true },
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'No underline on link',
              checked: !!attributes.noUnderlineOnLink,
              onChange: (val) => setAttributes({ noUnderlineOnLink: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet & Mobile Top Spacing',
              value: attributes.topTabletMobileSpacing || '',
              options: [
                { label: 'Inherit', value: '' },
                { label: 'None', value: 'none' },
                { label: 'Extra Small', value: 'xs' },
                { label: 'Small', value: 'sm' },
                { label: 'Medium', value: 'md' },
                { label: 'Large', value: 'lg' },
              ],
              onChange: (val) => setAttributes({ topTabletMobileSpacing: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet & Mobile Bottom Spacing',
              value: attributes.bottomTabletMobileSpacing || '',
              options: [
                { label: 'Inherit', value: '' },
                { label: 'None', value: 'none' },
                { label: 'Extra Small', value: 'xs' },
                { label: 'Small', value: 'sm' },
                { label: 'Medium', value: 'md' },
                { label: 'Large', value: 'lg' },
              ],
              onChange: (val) => setAttributes({ bottomTabletMobileSpacing: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet Font Size',
              value: attributes.tabletFontSize || '',
              options: fontSizeOptions,
              onChange: (val) => setAttributes({ tabletFontSize: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Mobile Font Size',
              value: attributes.mobileFontSize || '',
              options: fontSizeOptions,
              onChange: (val) => setAttributes({ mobileFontSize: val }),
            })
          )
        )
      );
    };
  }, 'withNdsParagraphSpacing')
);

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/paragraph/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/paragraph') {
      if (attributes.noUnderlineOnLink) {
        extraProps.className = (extraProps.className || '') + ' p-no-underline';
      }
      if (attributes.topTabletMobileSpacing) {
        const className = attributes.topTabletMobileSpacing === 'none' 
          ? 'max-lg:!mt-0' 
          : `top-tb-mb-${attributes.topTabletMobileSpacing}`;
        extraProps.className = (extraProps.className || '') + ` ${className}`;
      }
      if (attributes.bottomTabletMobileSpacing) {
        const className = attributes.bottomTabletMobileSpacing === 'none' 
          ? 'max-lg:!mb-0' 
          : `bottom-tb-mb-${attributes.bottomTabletMobileSpacing}`;
        extraProps.className = (extraProps.className || '') + ` ${className}`;
      }
      if (attributes.tabletFontSize) {
        extraProps.className = (extraProps.className || '') + ` tb-font-${attributes.tabletFontSize}`;
      }
      if (attributes.mobileFontSize) {
        extraProps.className = (extraProps.className || '') + ` mb-font-${attributes.mobileFontSize}`;
      }
    }
    return extraProps;
  }
);

wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/paragraph/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/paragraph') {
        let cls = props.className || '';
        const atts = props.block.attributes;
        if (atts.noUnderlineOnLink) cls += ' p-no-underline';
        if (atts.topTabletMobileSpacing) {
          const className = atts.topTabletMobileSpacing === 'none' 
            ? 'max-lg:!mt-0' 
            : `top-tb-mb-${atts.topTabletMobileSpacing}`;
          cls += ` ${className}`;
        }
        if (atts.bottomTabletMobileSpacing) {
          const className = atts.bottomTabletMobileSpacing === 'none' 
            ? 'max-lg:!mb-0' 
            : `bottom-tb-mb-${atts.bottomTabletMobileSpacing}`;
          cls += ` ${className}`;
        }
        if (atts.tabletFontSize) cls += ` tb-font-${atts.tabletFontSize}`;
        if (atts.mobileFontSize) cls += ` mb-font-${atts.mobileFontSize}`;
        if (cls !== (props.className || '')) {
          return wp.element.createElement(BlockListBlock, { ...props, className: cls });
        }
      }
      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withNdsParagraphEditorClass')
);

// ==== core/list customizations ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/list/register-attributes',
  (settings, name) => {
    if (name !== 'core/list') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        topTabletMobileSpacing: { type: 'string', default: '' },
        bottomTabletMobileSpacing: { type: 'string', default: '' },
        tabletFontSize: { type: 'string', default: '' },
        mobileFontSize: { type: 'string', default: '' },
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/list/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/list') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;

      // Get font sizes from theme.json
      const fontSizeOptions = [
        { label: 'Default', value: '' },
        { label: 'Extra Small', value: 'xs' },
        { label: 'Small', value: 'sm' },
        { label: 'Base', value: 'base' },
        { label: 'Medium', value: 'md' },
        { label: 'Medium 2', value: 'md2' },
        { label: 'Medium 3', value: 'md3' },
        { label: 'Large', value: 'lg' },
        { label: '2XL', value: '2xl' },
        { label: '3XL', value: '3xl' },
      ];

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options', initialOpen: true },
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet & Mobile Top Spacing',
              value: attributes.topTabletMobileSpacing || '',
              options: [
                { label: 'Inherit', value: '' },
                { label: 'None', value: 'none' },
                { label: 'Extra Small', value: 'xs' },
                { label: 'Small', value: 'sm' },
                { label: 'Medium', value: 'md' },
                { label: 'Large', value: 'lg' },
              ],
              onChange: (val) => setAttributes({ topTabletMobileSpacing: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet & Mobile Bottom Spacing',
              value: attributes.bottomTabletMobileSpacing || '',
              options: [
                { label: 'Inherit', value: '' },
                { label: 'None', value: 'none' },
                { label: 'Extra Small', value: 'xs' },
                { label: 'Small', value: 'sm' },
                { label: 'Medium', value: 'md' },
                { label: 'Large', value: 'lg' },
              ],
              onChange: (val) => setAttributes({ bottomTabletMobileSpacing: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet Font Size',
              value: attributes.tabletFontSize || '',
              options: fontSizeOptions,
              onChange: (val) => setAttributes({ tabletFontSize: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Mobile Font Size',
              value: attributes.mobileFontSize || '',
              options: fontSizeOptions,
              onChange: (val) => setAttributes({ mobileFontSize: val }),
            })
          )
        )
      );
    };
  }, 'withNdsListSpacing')
);

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/list/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/list') {
      if (attributes.topTabletMobileSpacing) {
        const className = attributes.topTabletMobileSpacing === 'none' 
          ? 'max-lg:!mt-0' 
          : `top-tb-mb-${attributes.topTabletMobileSpacing}`;
        extraProps.className = (extraProps.className || '') + ` ${className}`;
      }
      if (attributes.bottomTabletMobileSpacing) {
        const className = attributes.bottomTabletMobileSpacing === 'none' 
          ? 'max-lg:!mb-0' 
          : `bottom-tb-mb-${attributes.bottomTabletMobileSpacing}`;
        extraProps.className = (extraProps.className || '') + ` ${className}`;
      }
      if (attributes.tabletFontSize) {
        extraProps.className = (extraProps.className || '') + ` tb-font-${attributes.tabletFontSize}`;
      }
      if (attributes.mobileFontSize) {
        extraProps.className = (extraProps.className || '') + ` mb-font-${attributes.mobileFontSize}`;
      }
    }
    return extraProps;
  }
);

wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/list/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/list') {
        let cls = props.className || '';
        const atts = props.block.attributes;
        if (atts.topTabletMobileSpacing) {
          const className = atts.topTabletMobileSpacing === 'none' 
            ? 'max-lg:!mt-0' 
            : `top-tb-mb-${atts.topTabletMobileSpacing}`;
          cls += ` ${className}`;
        }
        if (atts.bottomTabletMobileSpacing) {
          const className = atts.bottomTabletMobileSpacing === 'none' 
            ? 'max-lg:!mb-0' 
            : `bottom-tb-mb-${atts.bottomTabletMobileSpacing}`;
          cls += ` ${className}`;
        }
        if (atts.tabletFontSize) cls += ` tb-font-${atts.tabletFontSize}`;
        if (atts.mobileFontSize) cls += ` mb-font-${atts.mobileFontSize}`;
        if (cls !== (props.className || '')) {
          return wp.element.createElement(BlockListBlock, { ...props, className: cls });
        }
      }
      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withNdsListEditorClass')
);

// ==== core/image customizations ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/image/register-attributes',
  (settings, name) => {
    if (name !== 'core/image') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        preventShrink: { type: 'boolean', default: false },
        topTabletMobileSpacing: { type: 'string', default: '' },
        bottomTabletMobileSpacing: { type: 'string', default: '' },
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/image/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/image') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options', initialOpen: true },
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Prevent Element from Shrinking',
              checked: !!attributes.preventShrink,
              onChange: (val) => setAttributes({ preventShrink: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet & Mobile Top Spacing',
              value: attributes.topTabletMobileSpacing || '',
              options: [
                { label: 'Inherit', value: '' },
                { label: 'None', value: 'none' },
                { label: 'Extra Small', value: 'xs' },
                { label: 'Small', value: 'sm' },
                { label: 'Medium', value: 'md' },
                { label: 'Large', value: 'lg' },
              ],
              onChange: (val) => setAttributes({ topTabletMobileSpacing: val }),
            }),
            wp.element.createElement(wp.components.SelectControl, {
              label: 'Tablet & Mobile Bottom Spacing',
              value: attributes.bottomTabletMobileSpacing || '',
              options: [
                { label: 'Inherit', value: '' },
                { label: 'None', value: 'none' },
                { label: 'Extra Small', value: 'xs' },
                { label: 'Small', value: 'sm' },
                { label: 'Medium', value: 'md' },
                { label: 'Large', value: 'lg' },
              ],
              onChange: (val) => setAttributes({ bottomTabletMobileSpacing: val }),
            })
          )
        )
      );
    };
  }, 'withNdsImageOptions')
);

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/image/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/image') {
      if (attributes.preventShrink) {
        extraProps.className = (extraProps.className || '') + ' shrink-0';
      }
      if (attributes.topTabletMobileSpacing) {
        const className = attributes.topTabletMobileSpacing === 'none' 
          ? 'max-lg:!mt-0' 
          : `top-tb-mb-${attributes.topTabletMobileSpacing}`;
        extraProps.className = (extraProps.className || '') + ` ${className}`;
      }
      if (attributes.bottomTabletMobileSpacing) {
        const className = attributes.bottomTabletMobileSpacing === 'none' 
          ? 'max-lg:!mb-0' 
          : `bottom-tb-mb-${attributes.bottomTabletMobileSpacing}`;
        extraProps.className = (extraProps.className || '') + ` ${className}`;
      }
    }
    return extraProps;
  }
);

wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/image/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/image') {
        let cls = props.className || '';
        const atts = props.block.attributes;
        if (atts.preventShrink) cls += ' shrink-0';
        if (atts.topTabletMobileSpacing) {
          const className = atts.topTabletMobileSpacing === 'none' 
            ? 'max-lg:!mt-0' 
            : `top-tb-mb-${atts.topTabletMobileSpacing}`;
          cls += ` ${className}`;
        }
        if (atts.bottomTabletMobileSpacing) {
          const className = atts.bottomTabletMobileSpacing === 'none' 
            ? 'max-lg:!mb-0' 
            : `bottom-tb-mb-${atts.bottomTabletMobileSpacing}`;
          cls += ` ${className}`;
        }
        if (cls !== (props.className || '')) {
          return wp.element.createElement(BlockListBlock, { ...props, className: cls });
        }
      }
      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withNdsImageEditorClass')
);

// ==== core/spacer customizations ====

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'nds/spacer/register-attributes',
  (settings, name) => {
    if (name !== 'core/spacer') return settings;

    return {
      ...settings,
      attributes: {
        ...settings.attributes,
        disableOnTablet: { type: 'boolean', default: false },
        disableOnMobile: { type: 'boolean', default: false },
      },
    };
  }
);

wp.hooks.addFilter(
  'editor.BlockEdit',
  'nds/spacer/block-edit',
  wp.compose.createHigherOrderComponent((BlockEdit) => {
    return (props) => {
      if (props.name !== 'core/spacer') return wp.element.createElement(BlockEdit, props);

      const { attributes, setAttributes } = props;

      return wp.element.createElement(
        wp.element.Fragment,
        {},
        wp.element.createElement(BlockEdit, props),
        wp.element.createElement(
          wp.blockEditor.InspectorControls,
          {},
          wp.element.createElement(
            wp.components.PanelBody,
            { title: 'NDS Custom Options', initialOpen: true },
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Disable on Tablet',
              checked: !!attributes.disableOnTablet,
              onChange: (val) => setAttributes({ disableOnTablet: val }),
            }),
            wp.element.createElement(wp.components.ToggleControl, {
              label: 'Disable on Mobile',
              checked: !!attributes.disableOnMobile,
              onChange: (val) => setAttributes({ disableOnMobile: val }),
            })
          )
        )
      );
    };
  }, 'withNdsSpacerOptions')
);

wp.hooks.addFilter(
  'blocks.getSaveContent.extraProps',
  'nds/spacer/save-class',
  (extraProps, blockType, attributes) => {
    if (blockType.name === 'core/spacer') {
      if (attributes.disableOnTablet) {
        extraProps.className = (extraProps.className || '') + ' is-hidden-tablet';
      }
      if (attributes.disableOnMobile) {
        extraProps.className = (extraProps.className || '') + ' is-hidden-mobile';
      }
    }
    return extraProps;
  }
);

wp.hooks.addFilter(
  'editor.BlockListBlock',
  'nds/spacer/editor-class',
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      if (props.block.name === 'core/spacer') {
        let cls = props.className || '';
        const atts = props.block.attributes;
        if (atts.disableOnTablet) cls += ' is-hidden-tablet';
        if (atts.disableOnMobile) cls += ' is-hidden-mobile';
        if (cls !== (props.className || '')) {
          return wp.element.createElement(BlockListBlock, { ...props, className: cls });
        }
      }
      return wp.element.createElement(BlockListBlock, props);
    };
  }, 'withNdsSpacerEditorClass')
);