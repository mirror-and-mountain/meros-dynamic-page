<?php 

namespace MM\Meros\DynamicPage;

use MM\Meros\Contracts\Extension;

class MerosDynamicPage extends Extension
{
    protected string $authorName = "Meros";
    protected string $authorUrl = "https://merosblocks.com";
    protected string $authorSupportUrl = "https://merosblocks.com/support";
    protected string $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua';

    final protected function configure(): void
    {
        $this->loadAssets( true );
        $this->loadComponents();
        $this->loadViews();

        $this->addSettings();
        $this->includeHooks();
    }

    private function includeHooks(): void
    {
        include dirname(__FILE__) . '/hooks/actions.php';
        include dirname(__FILE__) . '/hooks/filters.php';
    }

    private function addSettings()
    {
        $this->addSetting(
            'dynamic_page_loader_color',
            'Dynamic Page Loading Bar Colour',
            'theme_settings',
            'styles',
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