<?php 
/**
 * Adds additional SPA controls to the Meros Carousel plugin in the
 * block editor.
 */
add_action('enqueue_block_editor_assets', function () {
    $block = \WP_Block_Type_Registry::get_instance()->get_registered('meros/carousel');

    if ($block && !empty($block->editor_script_handles)) {
        wp_add_inline_script(
            'meros-carousel-editor-script',
            'window.MerosDynamicPage = true;',
            'before'
        );        
    }
});