<?php 

namespace MM\Meros\DynamicPage;

use Illuminate\Support\Str;
use MM\Meros\Contracts\Feature as AbstractFeature;

class Feature extends AbstractFeature
{
    protected function configure(): void
    {
        $this->hasAssets     = true;
        $this->hasComponents = true;

        add_filter('template_include', function ( $template ) {
            if ( Str::endsWith($template, 'template-canvas.php') ) {
                $template_html    = get_the_block_template_html();
                $template_path    = wp_normalize_path( __DIR__ . '/template/meros-dp-template.php' );
                $dynamic_template = load_template( $template_path, true, ['template_markup' => $template_html] );

                return $dynamic_template;
            }
        }, 10, 3);
    }
}