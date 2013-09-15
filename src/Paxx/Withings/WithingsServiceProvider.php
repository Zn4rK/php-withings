<?php namespace Paxx\Withings;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class WithingsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
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
        $loader->alias('WithingsAuth', 'Paxx\Withings\Provider\Withings');

    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app['withingsapi'] = $this->app->share(function($app)
		{
			return new Api;
		});
	}


}