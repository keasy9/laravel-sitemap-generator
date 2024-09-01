<?php

declare(strict_types=1);

namespace Keasy9\SitemapGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Keasy9\SitemapGenerator\Console\Commands\Cleaner;
use Keasy9\SitemapGenerator\Console\Commands\Generator;
use Keasy9\SitemapGenerator\Services\SitemapGeneratorService;

class SitemapGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        parent::register();
        $this->app->singleton(SitemapGeneratorService::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Cleaner::class,
                Generator::class,
            ]);
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/sitemap-generator.php', 'sitemap-generator');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sitemap-generator');

        $this->publishes([
            __DIR__ . '/../config/sitemap-generator.php' => config_path('sitemap-generator.php'),
            __DIR__ . '/../resources/views'              => resource_path('views/vendor/sitemap-generator'),
        ], 'sitemap-generator');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'sitemap-generator-migrations');
    }
}
