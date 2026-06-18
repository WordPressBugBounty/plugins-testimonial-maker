(function(wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var el = wp.element.createElement;
    var SelectControl = wp.components.SelectControl;
    var useBlockProps = wp.blockEditor.useBlockProps;

    // Testimonial Shortcode Block
    registerBlockType('tml-shortcode/block', {
        title: 'Testimonial Shortcode',
        icon: 'format-status',
        category: 'testimonial-maker',
        attributes: {
            shortcodeId: {
                type: 'string',
                default: ''
            }
        },
        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var options = [{ label: 'Select a Shortcode', value: '' }];
            if (window.tmlBlockData && window.tmlBlockData.shortcodes) {
                options = options.concat(window.tmlBlockData.shortcodes);
            }

            return el('div', useBlockProps({ style: { border: '1px solid #2271b1', padding: '20px', background: '#f0f6fc', borderRadius: '4px' } }),
                el('h4', { style: { margin: '0 0 15px 0', display: 'flex', alignItems: 'center' } }, 
                    el('span', { className: 'dashicons dashicons-format-status', style: { marginRight: '10px' } }),
                    'Testimonial Maker Shortcode'
                ),
                el(SelectControl, {
                    label: 'Choose shortcode to display:',
                    value: attributes.shortcodeId,
                    options: options,
                    onChange: function(val) {
                        setAttributes({ shortcodeId: val });
                    }
                }),
                attributes.shortcodeId ? el('p', { style: { fontSize: '12px', color: '#666', marginTop: '10px' } }, 'Shortcode: [TML id="' + attributes.shortcodeId + '"]') : null
            );
        },
        save: function(props) {
            return null; // Server-side rendering
        }
    });

})(window.wp);
