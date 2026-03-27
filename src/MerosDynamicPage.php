<?php 

namespace MM\Meros\DynamicPage;

use MM\Meros\App\Services\Theme\Package;

class MerosDynamicPage extends Package {
    public string $author           = "Meros";
    public string $authorUri        = "https://merosblocks.com";
    public string $authorSupportUri = "https://merosblocks.com/support";
    public string $description      = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';
    
    public bool $experimental = true;

    protected function configure(): void {
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

    protected function discover(): void {
        // Set the assets structure for this extension.
        $this->assetsStructure = '/{location}/*.{extension}';

        $this->discoverAssets(true);
        $this->discoverComponents();
        $this->discoverViews();
    }
}