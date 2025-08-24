<?php 

namespace MM\Meros\DynamicPage;

use MM\Meros\Contracts\Extension;

class Feature extends Extension
{
    final protected function configure(): void
    {
       $this->author = [
            'name'    => 'MIRROR AND MOUNTAIN',
            'link'    => 'https://mirrorandmountain.com',
            'support' => 'https://mirrorandmountain.com/support'
        ];

        $this->hasIncludes        = true;
        $this->hasAssets          = true;
        $this->putScriptsInFooter = true;
        $this->hasComponents      = true;
        $this->category           = 'styles';

        add_filter($this->name . '_user_switch_label', 
            function ( $value ) {
                return 'Enable or disable Single Page Loading.'; 
            }
        );
    }

    protected function override(): void
    {
        // User overrides can go here.
    }
}