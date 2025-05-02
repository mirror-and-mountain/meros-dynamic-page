<!DOCTYPE html>
<html <?php language_attributes(); ?> >
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php the_title()?></title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
        <!-- MM Dynamic Page Livewire Component -->
        <?php echo \Livewire\Livewire::mount('meros_dynamic_page.page');
        wp_footer(); ?>
    </body>
</html>