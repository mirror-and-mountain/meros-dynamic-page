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

        include __DIR__ . '/includes/hooks.php';
    }
}