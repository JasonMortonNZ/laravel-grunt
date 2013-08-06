<?php namespace JasonMortonNZ\LaravelGrunt;

use Illuminate\Support\ServiceProvider;

class LaravelGruntServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerBuildCommand();
		$this->registerSetupCommand();
		$this->registerWatchCommand();

		$this->registerCommands();
	}

	/**
	 * Register the grunt.setup command to the IoC
	 * 
	 * @return  JasonMortonNZ\LaravelGrunt\GruntSetupCommand
	 */
	public function registerSetupCommand()
	{
		$this->app['grunt.setup'] = $this->app->share(function($app)
		{
			$gruntFile = new Gruntfile($app['files'], $app['config']);
			$gruntGenerator = new GruntGenerator($app['files'], $gruntFile, $app['config']);
			return new GruntSetupCommand($gruntGenerator, $app['config']);
		});
	}

	/**
	 * Register the grunt.build command to the IoC
	 * 
	 * @return  JasonMortonNZ\LaravelGrunt\GruntBuildCommand
	 */
	public function registerBuildCommand()
	{
		$this->app['grunt.build'] = $this->app->share(function($app)
		{
			return new GruntBuildCommand();
		});
	}

	/**
	 * Register the grunt.watch command to the IoC
	 * 
	 * @return  JasonMortonNZ\LaravelGrunt\GruntWatchCommand
	 */
	public function registerWatchCommand()
	{
		$this->app['grunt.watch'] = $this->app->share(function($app)
		{
			return new GruntWatchCommand();
		});
	}

	/**
	 * Make commands visible to Artisan
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
		$this->commands(
			'grunt.setup',
			'grunt.build',
			'grunt.watch'
		);
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('jason-morton-nz/laravel-grunt');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}