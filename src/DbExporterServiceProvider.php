<?php

namespace Haykabrahamyan\DbExporter;

use Illuminate\Support\ServiceProvider;

class DbExporterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
//        include __DIR__.'/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Haykabrahamyan\DbExporter\DbExporterController');
    }
}
