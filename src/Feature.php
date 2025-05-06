<?php 

namespace MM\Meros\DynamicPage;

use Illuminate\Support\Str;
use MM\Meros\Contracts\Extension;

class Feature extends Extension
{
    final protected function configure(): void
    {
        $this->hasAssets          = true;
        $this->putScriptsInFooter = true;
        $this->hasComponents      = true;
    }

    protected function override(): void
    {
        // User overrides can go here.
    }

    final public function initialise(): void
    {
        parent::initialise();

        if ( $this->enabled ) {
            add_filter('template_include', function ( $template ) {
                if ( Str::endsWith($template, 'template-canvas.php') ) {
                    $template_html    = get_the_block_template_html();
                    $template_path    = wp_normalize_path( __DIR__ . '/template/meros-dp-template.php' );
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
        }
    }
}