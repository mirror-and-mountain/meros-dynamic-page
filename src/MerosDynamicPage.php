<?php 

namespace MM\Meros\DynamicPage;

use MM\Meros\Contracts\Extension;

class MerosDynamicPage extends Extension {
    protected string $authorName = "Meros";
    protected string $authorUrl = "https://merosblocks.com";
    protected string $authorSupportUrl = "https://merosblocks.com/support";
    protected string $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';
    public bool $experimental = true;

    final protected function boot(): void {
        // Set the assets structure for this extension.
        $this->assetsStructure = '/{location}/*.{extension}';

        // Register filters
        $featureFilters = MerosDynamicPageFilters::init($this->hookPrefix);
        $featureFilters->register();

        // Load assets and components
        $this->loadAssets( true );
        $this->loadComponents();
        $this->loadViews();

        // Add Settings
        $this->addSettings();
    }

    private function addSettings(): void {
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
}