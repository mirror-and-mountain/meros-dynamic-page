<?php

// Ensure Livewire assets are injected into the Wordpress header and footer
\MM\Meros\Helpers\Livewire::injectAssets();

/**
 * Intercepts the theme template and replaces it with our
 * template as ../template/.
 */
add_filter('template_include', function ( $template ) {
    if ( \Illuminate\Support\Str::endsWith($template, 'template-canvas.php') ) {
        // I'm not 100% sure why I need to call this, but block spacing seems to suffer if I don't!
        $template_html    = get_the_block_template_html();
        // Fetch our template.
        $template_path    = wp_normalize_path( dirname(__FILE__, 2) . '/template/meros-dp-template.php' );
        // Load the template.
        $dynamic_template = load_template( $template_path, true, ['template_markup' => $template_html] );

        return $dynamic_template;
    }
}, 10, 3);

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