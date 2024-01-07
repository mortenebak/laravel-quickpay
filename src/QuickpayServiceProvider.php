<?php

namespace Netbums\Quickpay;

use Netbums\Quickpay\Commands\QuickpayCommand;
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
            ->hasViews()
            ->hasMigration('create_laravel-quickpay_table')
            ->hasCommand(QuickpayCommand::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/quickpay.php' => config_path('quickpay.php'),
        ], 'config');
    }

    public function register(): void
    {

        $this->app->singleton('quickpay', function ($app) {
            return new Quickpay();
        });

    }

    public function provides(): array
    {
        return ['quickpay'];
    }
}
