<?php

namespace MM\Meros\DynamicPage\Components;

use Livewire\Component;
use MM\Meros\DynamicPage\MerosDynamicPage;

class Page extends Component
{
    private array $blocks;
    public string $loadingBarColour;
    public ?int   $postId;

    public function mount()
    {
        global $_wp_current_template_content;
        global $post;

        $feature = app()->make(MerosDynamicPage::class);
        $this->loadingBarColour = $feature->getSetting(
            'theme_settings_scripts_and_styles', 
            '_meros_dynamic_page_dynamic_page_loader_color'
        );

        $this->blocks = parse_blocks($_wp_current_template_content);
        $this->postId = isset($post) ? $post->ID : null;
    }
    
    public function render()
    {
        return view('meros_dynamic_page::page', [
            'blocks' => $this->blocks,
            'loadingBarColour' => $this->loadingBarColour,
        ]);
    }
}