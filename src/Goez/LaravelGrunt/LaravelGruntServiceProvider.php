<?php

namespace Goez\LaravelGrunt;

use Goez\LaravelGrunt\Commands\GruntInitCommand;
use Illuminate\Support\ServiceProvider;
use Goez\LaravelGrunt\Grunt\Gruntfile;
use Goez\LaravelGrunt\Grunt\GruntGenerator;
use Goez\LaravelGrunt\Bower\Bowerfile;
use Goez\LaravelGrunt\Bower\BowerGenerator;
use Goez\LaravelGrunt\Commands\GruntConfigCommand;
use Goez\LaravelGrunt\Commands\GruntSetupCommand;

class LaravelGruntServiceProvider extends ServiceProvider
{
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
        $this->registerGruntConfigCommand();
        $this->registerGruntSetupCommand();
        $this->registerGruntInitCommand();
        $this->registerCommands();
    }

    /**
     * Register the grunt.config command to the IoC
     *
     * @return \Goez\LaravelGrunt\Commands\GruntConfigCommand
     */
    public function registerGruntConfigCommand()
    {
        $this->app['grunt.config'] = $this->app->share(function($app) {
            return new GruntConfigCommand();
        });
    }

    /**
     * Register the grunt.setup command to the IoC
     *
     * @return \Goez\LaravelGrunt\Commands\GruntSetupCommand
     */
    public function registerGruntSetupCommand()
    {
        $this->app['grunt.setup'] = $this->app->share(function($app) {

            $bowerFile = new Bowerfile($app['files'], $app['config']);
            $bowerGenerator = new BowerGenerator($app['files'], $bowerFile, $app['config']);
            $gruntFile = new Gruntfile($app['files'], $app['config']);
            $gruntGenerator = new GruntGenerator($app['files'], $gruntFile, $app['config']);

            return new GruntSetupCommand(array($bowerGenerator, $gruntGenerator), $app['config']);
        });
    }

    public function registerGruntInitCommand()
    {
        $this->app['grunt.init'] = $this->app->share(function ($app) {

            return new GruntInitCommand($app['files'], $app['config']);

        });
    }

    public function registerCommands()
    {
        $this->commands(
            'grunt.config',
            'grunt.setup',
            'grunt.init'
        );
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('goez/laravel-grunt');
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
