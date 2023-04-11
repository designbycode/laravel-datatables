<?php

namespace Designbycode\Datatables;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DatatablesServiceProvider extends PackageServiceProvider
{
    public string $name = 'datatables';

    public function configurePackage(Package $package): void
    {

        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('datatables')
            ->hasConfigFile()
            ->hasViews();
    }
}
