<?php

namespace Netbums\Quickpay;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class QuickpayServiceProvider extends PackageServiceProvider
{
    protected bool $defer = true;

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
            ->publishesServiceProvider('QuickpayServiceProvider')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('mortenebak/laravel-quickpay');
            });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/quickpay.php' => config_path('quickpay.php'),
        ], 'laravel-quickpay-config');
    }

    public function register(): void
    {

        $this->app->singleton(\Netbums\Quickpay\Quickpay::class, function ($app) {
            return new Quickpay();
        });

    }

    public function provides(): array
    {
        return ['quickpay'];
    }
}
