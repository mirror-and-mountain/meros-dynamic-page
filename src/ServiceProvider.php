<?php 

namespace MM\Meros\DynamicPage;

use MM\Meros\App\Providers\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider {
    protected string $serviceClass = MerosDynamicPage::class;
}