<?php

declare(strict_types=1);

namespace Netbums\Quickpay;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class QuickpayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-quickpay')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('mortenebak/laravel-quickpay');
            });
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Quickpay::class, fn () => new Quickpay());
    }

    public function packageBooted(): void
    {
        // Kept so `vendor:publish --tag=laravel-quickpay-config` from earlier versions still works.
        $this->publishes([
            $this->package->basePath('/../config/quickpay.php') => config_path('quickpay.php'),
        ], 'laravel-quickpay-config');
    }
}
