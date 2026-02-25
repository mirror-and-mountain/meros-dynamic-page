<?php 

namespace MM\Meros\DynamicPage;

use Illuminate\Support\Str;
use MM\Meros\Helpers\Theme\Filters;

class MerosDynamicPageFilters extends Filters {

    public function register(): void {
        $this->add('template_include', [$this, 'includeTemplate'], 10, 3);
        $this->add('render_block', [$this, 'renderCompatibleBlocks'], 10, 2);
    }

    /**
     * Includes the dynamic page template if enabled
     *
     * @param string $template
     * @return string
     */
    public function includeTemplate(string $template): ?string {
        if (Str::endsWith($template, 'template-canvas.php')) {
            // I'm not 100% sure why I need to call this, but block spacing seems to suffer if I don't!
            $template_html    = get_the_block_template_html();
            // Fetch our template.
            $template_path    = wp_normalize_path( __DIR__ . '/template/meros-dp-template.php' );
            // Load the template.
            $dynamic_template = load_template( $template_path, true, ['template_markup' => $template_html] );

            return $dynamic_template;
        }

        return null;
    }

    /**
     * Wraps compatible blocks in a persistance wrapper if enabled.
     *
     * @param string $block_content The HTML content of the block being rendered.
     * @param array $block The block being rendered.
     * @return string The updated HTML content of the block.
     */
    public function renderCompatibleBlocks(string $block_content, array $block): string {
        $attrs = $block['attrs'] ?? null;
    
        if (!is_array($attrs)) { return $block_content; }

        $blocks = [
            'core/group',
            'core/template-part',
            'meros/swiper'
        ];

        if (in_array($block['blockName'], $blocks) && 
            isset($attrs['enableMerosPersist']) &&
            isset($attrs['merosPersistID'])
        ) {
            $processor = new WP_HTML_Tag_Processor($block_content);
            if ($processor->next_tag()) {
                $processor->set_attribute('x-persist', $attrs['merosPersistID']);
            }
            return $processor->get_updated_html();
        }

        if (
            (isset($block['attrs']['slug']) && 
            $block['attrs']['slug'] === 'header') ||
            (isset($block['attrs']['tagName']) &&
            $block['attrs']['tagName'] === 'header')
        ) {
            $block_content = '<div x-persist="header">' . $block_content . '</div>';
            return $block_content;
        }

        return $block_content;
    }
}