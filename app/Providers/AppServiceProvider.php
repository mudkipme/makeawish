<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * @var \Illuminate\Translation\FileLoader
         */
        $loader = $this->app['translation.loader'];
        $loader->addJsonPath(base_path('resources/locale'));
        $loader->addJsonPath(base_path(Config::get('app.content_folder')));
    }
}
