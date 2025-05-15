<?php

\MM\Meros\Helpers\Livewire::injectAssets();

add_filter('template_include', function ( $template ) {
    if ( \Illuminate\Support\Str::endsWith($template, 'template-canvas.php') ) {
        $template_html    = get_the_block_template_html();
        $template_path    = wp_normalize_path( dirname(__FILE__, 2) . '/template/meros-dp-template.php' );
        $dynamic_template = load_template( $template_path, true, ['template_markup' => $template_html] );

        return $dynamic_template;
    }
}, 10, 3);

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