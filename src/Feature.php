<?php 

namespace MM\Meros\DynamicPage;

use MM\Meros\Contracts\Extension;

class Feature extends Extension
{
    final protected function configure(): void
    {
        $this->author             = 'MIRROR AND MOUNTAIN';
        $this->hasIncludes        = true;
        $this->hasAssets          = true;
        $this->putScriptsInFooter = true;
        $this->hasComponents      = true;

        add_filter($this->name . '_user_switch_label', 
            function ( $value ) {
                return 'Enable Single Page Loading.'; 
            }
        );
    }

    protected function override(): void
    {
        // User overrides can go here.
    }
}