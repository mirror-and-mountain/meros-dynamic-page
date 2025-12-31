import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

const addPersistAttribute = (settings, name) => {
    if (name !== 'core/group' && 
        name !== 'core/template-part'
    ) return settings;

    return {
        ...settings,
        attributes: {
            ...settings.attributes,
            enableMerosPersist: { type: 'boolean', default: false },
            merosPersistID: { type: 'string', default: '' }
        }
    };
};
addFilter('blocks.registerBlockType', 'meros/persist-attribute', addPersistAttribute);

wp.domReady(() => {
    // Add controls to the inspector for the group blocks
    const addPersistControl = createHigherOrderComponent((BlockEdit) => {
        return (props) => {
            const { name, attributes, setAttributes } = props;

            if (name !== 'core/group' && 
                name !== 'core/template-part'
            ) {
                return <BlockEdit {...props} />;
            }

            const persistId = `persist-${Math.random().toString(36).substring(2, 9)}`;

            return (
                <Fragment>
                    <BlockEdit {...props} />
                    <InspectorControls>
                        <PanelBody title={__('Single Page Application Behaviour', 'meros-dynamic-page')} initialOpen={false}>
                            <ToggleControl
                                label={__('Persist Block', 'meros-dynamic-page')}
                                checked={attributes.enableMerosPersist}
                                onChange={(value) => {
                                    setAttributes({ enableMerosPersist: value })
                                    if (!attributes.merosPersistID) {
                                        setAttributes({
                                            merosPersistID: persistId
                                        });
                                    }
                                }}
                            />
                            { attributes.enableMerosPersist === true  && (
                                <TextControl
                                    label={__('Block ID', 'meros-dynamic-page')}
                                    value={ attributes.merosPersistID || persistId }
                                    onChange={(value) => {
                                        setAttributes({ merosPersistID: value })
                                    }}
                                />
                            )}
                        </PanelBody>
                    </InspectorControls>
                </Fragment>
            );
        };
    }, 'addPersistControl');
    addFilter('editor.BlockEdit', 'meros/persist-control', addPersistControl);
});
