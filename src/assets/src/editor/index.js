import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

const addPersistAttribute = (settings, name) => {
    if (name !== 'core/group' && 
        name !== 'core/template-part' &&
        name !== 'meros/swiper'
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
            const { name, attributes, setAttributes, clientId } = props;

            if (name !== 'core/group' && 
                name !== 'core/template-part' &&
                name !== 'meros/swiper'
            ) {
                return <BlockEdit {...props} />;
            }

            const isHeader = 
                (name === 'core/template-part' && attributes.slug === 'header') ||
                (name === 'core/group' && attributes.tagName === 'header');

            if (isHeader) {
                return <BlockEdit {...props} />;
            }

            const isInHeader = isChildOf(clientId, [
                'core/template-part',
                'core/group'
            ], (parentBlock) => {
                return (parentBlock.name === 'core/template-part' && parentBlock.attributes.slug === 'header') ||
                    (parentBlock.name === 'core/group' && parentBlock.attributes.tagName === 'header');
            });

            if (isInHeader) {
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
                                __nextHasNoMarginBottom={true}
                                __next40pxDefaultSize={true}
                            />
                            { attributes.enableMerosPersist === true  && (
                                <TextControl
                                    label={__('Block ID', 'meros-dynamic-page')}
                                    value={ attributes.merosPersistID || persistId }
                                    onChange={(value) => {
                                        setAttributes({ merosPersistID: value })
                                    }}
                                    __next40pxDefaultSize={true}
                                    __nextHasNoMarginBottom={true}
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

/**
 * Checks if a block is a child of a specified parent block type.
 *
 * @param {string} clientId - The client ID of the block to check.
 * @param {string|string[]} parentNames - The name(s) of the parent block to check against.
 * @param {Function|null} logicalTest - Optional function to apply additional logic on the parent block.
 * @returns {boolean} True if the block is a child of the specified parent, false otherwise.
 */
function isChildOf(clientId, parentNames, logicalTest = null) {
    const { getBlock, getBlockParents } = wp.data.select('core/block-editor');
    const parents = getBlockParents(clientId);

    for (const parentId of parents) {
        const parentBlock = getBlock(parentId);
        
        if (Array.isArray(parentNames)) {
            if (parentBlock && parentNames.includes(parentBlock.name) &&
                (typeof logicalTest !== 'function' || logicalTest(parentBlock) === true)
            ) {
                return true;
            }


        } else if (parentBlock &&
            parentBlock.name === parentNames &&
            (typeof logicalTest !== 'function' || logicalTest(parentBlock) === true)
        ) {
            return true;
        }
    }

    return false;
}
