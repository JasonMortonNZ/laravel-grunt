<?php namespace JasonNZ\LaravelGrunt;

use Illuminate\Support\ServiceProvider;
use JasonNZ\LaravelGrunt\Grunt\Gruntfile;
use JasonNZ\LaravelGrunt\Grunt\GruntGenerator;
use JasonNZ\LaravelGrunt\Bower\Bowerfile;
use JasonNZ\LaravelGrunt\Bower\BowerGenerator;
use JasonNZ\LaravelGrunt\Commands\GruntSetupCommand;
use JasonNZ\LaravelGrunt\Commands\GruntBuildCommand;
use JasonNZ\LaravelGrunt\Commands\GruntWatchCommand;
use JasonNZ\LaravelGrunt\Commands\GruntConfigCommand;
use JasonNZ\LaravelGrunt\Commands\BowerSetupCommand;
use JasonNZ\LaravelGrunt\Commands\BowerInstallCommand;
use JasonNZ\LaravelGrunt\Commands\BowerUpdateCommand;

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
		// Register Grunt Related Stuff
		$this->registerGruntConfigCommand();
		$this->registerGruntSetupCommand();
		$this->registerGruntBuildCommand();
		$this->registerGruntWatchCommand();
		
		// Register Bower Related Stuff
		$this->registerBowerSetupCommand();
		$this->registerBowerInstallCommand();
		$this->registerBowerUpdateCommand();
		
		// Register Artisan Commands
		$this->registerCommands();
	}

	/**
	 * Register the grunt.setup command to the IoC
	 * 
	 * @return  JasonNZ\LaravelGrunt\Commands\GruntSetupCommand
	 */
	public function registerGruntSetupCommand()
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
	 * @return  JasonNZ\LaravelGrunt\Commands\GruntBuildCommand
	 */
	public function registerGruntBuildCommand()
	{
		$this->app['grunt.build'] = $this->app->share(function($app)
		{
			return new GruntBuildCommand();
		});
	}

	/**
	 * Register the grunt.config command to the IoC
	 * 
	 * @return  JasonNZ\LaravelGrunt\Commands\GruntConfigCommand
	 */
	public function registerGruntConfigCommand()
	{
		$this->app['grunt.config'] = $this->app->share(function($app)
		{
			return new GruntConfigCommand();
		});
	}

	/**
	 * Register the grunt.watch command to the IoC
	 * 
	 * @return  JasonNZ\LaravelGrunt\Commands\GruntWatchCommand
	 */
	public function registerGruntWatchCommand()
	{
		$this->app['grunt.watch'] = $this->app->share(function($app)
		{
			return new GruntWatchCommand();
		});
	}

	/**
	 * Register the bower.setup command to the IoC
	 * 
	 * @return  JasonNZ\LaravelGrunt\Commands\BowerSetupCommand
	 */
	public function registerBowerSetupCommand()
	{
		$this->app['bower.setup'] = $this->app->share(function($app)
		{
			$bowerFile = new Bowerfile($app['files'], $app['config']);
			$bowerGenerator = new BowerGenerator($app['files'], $bowerFile, $app['config']);
			return new BowerSetupCommand($bowerGenerator, $app['config']);
		});
	}

	/**
	 * Register the bower.install command to the IoC
	 * 
	 * @return  JasonNZ\LaravelGrunt\Commands\BowerInstallCommand
	 */
	public function registerBowerInstallCommand()
	{
		$this->app['bower.install'] = $this->app->share(function($app)
		{
			return new BowerInstallCommand();
		});
	}

	/**
	 * Register the bower.update command to the IoC
	 * 
	 * @return  JasonNZ\LaravelGrunt\Commands\BowerUpdateCommand
	 */
	public function registerBowerUpdateCommand()
	{
		$this->app['bower.update'] = $this->app->share(function($app)
		{
			return new BowerUpdateCommand();
		});
	}

	public function registerCommands()
	{
		$this->commands(
			'grunt.setup',
			'grunt.build',
			'grunt.config',
			'grunt.watch',
			'bower.setup',
			'bower.install',
			'bower.update'
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
