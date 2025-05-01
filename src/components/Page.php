<?php

namespace MM\Meros\DynamicPage\Components;

use Livewire\Component;

class Page extends Component
{
    private array $blocks;

    public function mount()
    {
        global $_wp_current_template_content;

        $this->blocks = parse_blocks($_wp_current_template_content);
    }
    
    public function render()
    {
        return view('meros_dynamic_page::page', [
            'blocks' => $this->blocks
        ]);
    }
}