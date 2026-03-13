<?php 

namespace MM\Meros\DynamicPage;

use MM\Meros\Contracts\Extension;

class MerosDynamicPage extends Extension {
    protected string $authorName = "Meros";
    protected string $authorUrl = "https://merosblocks.com";
    protected string $authorSupportUrl = "https://merosblocks.com/support";
    protected string $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';
    public bool $experimental = true;

    protected function addFilters(): void {
        $this->addFilter('template_include', [Filters::class, 'includeTemplate'], 10, 3);
        $this->addFilter('render_block', [Filters::class, 'renderCompatibleBlocks'], 10, 2);
    }

    protected function registerSettings(): void {
        $this->addSetting(
            'dynamic_page_loader_color',
            'Dynamic Page Loading Bar Colour',
            'theme_settings',
            'scripts_and_styles',
            '',
            '',
            [
                'type' => 'color',
                'default' => '#2299dd',
                'description' => 'Select the colour of the loading bar shown when navigating between dynamic pages.',
            ]
        );
    }

    protected function loadFeatures(): void {
        // Set the assets structure for this extension.
        $this->assetsStructure = '/{location}/*.{extension}';

        $this->loadAssets(true);
        $this->loadComponents();
        $this->loadViews();
    }
}