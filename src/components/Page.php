<?php

namespace MM\Meros\DynamicPage\Components;

use Livewire\Component;

class Page extends Component
{
    private array $blocks;
    public ?int   $postId;
    public string $loadingBarColour;

    public function mount()
    {
        global $_wp_current_template_content;
        global $post;

        $this->blocks = parse_blocks($_wp_current_template_content);
        $this->postId = isset($post) ? $post->ID : null;
        $this->loadingBarColour = get_option(
            'meros_meros_dynamic_page_dynamic_page_loader_color', 
            '#2299dd'
        );
    }
    
    public function render()
    {
        return view('meros_dynamic_page::page', [
            'blocks' => $this->blocks,
            'loadingBarColour' => $this->loadingBarColour,
        ]);
    }
}