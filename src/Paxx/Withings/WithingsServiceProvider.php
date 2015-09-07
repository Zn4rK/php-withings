<?php

namespace Paxx\Withings;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class WithingsServiceProvider extends ServiceProvider
{
    /**
     * Indicates whether loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('paxx/withings');

        $loader = AliasLoader::getInstance();

        $loader->alias('WithingsApi', 'Paxx\Withings\Api');
        $loader->alias('WithingsAuth', 'Paxx\Withings\Server\Withings');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['withingsapi'] = $this->app->share(function ($app) {
            return new Api;
        });
    }
}
