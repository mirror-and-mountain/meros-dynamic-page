<?php 

namespace MM\Meros\DynamicPage;

use MM\Meros\Contracts\Feature as AbstractFeature;

class Feature extends AbstractFeature
{
    protected function configure(): void
    {
        $this->hasAssets     = true;
        $this->hasComponents = true;
    }
}