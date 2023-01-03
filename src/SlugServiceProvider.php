<?php

namespace Hexatex\Slug;

use Illuminate\Routing\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Hexatex\Slug\Commands\SlugCommand;

class SlugServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('slug')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_slug_table')
            ->hasCommand(SlugCommand::class);
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        Route::bind('slug', function ($slugString) {
            return Slug::bySlug($slugString)->firstOrFail();
        });
    }
}
