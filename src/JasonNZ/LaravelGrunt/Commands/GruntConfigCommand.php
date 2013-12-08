<?php namespace JasonNZ\LaravelGrunt\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GruntConfigCommand extends Command {

	/**
	 * The console command name
	 *
	 * @var string
	 */
	protected $name = 'grunt:config';

	/**
	 * The consolse command description
	 *
	 * @var string
	 */
	protected $description = 'Copy configuration file to app/config/packages folder.';

	public function fire()
	{
		$this->info('Copied Laravel-Grunt config file to: app/config/package/jason-morton-nz/laravel-grunt/src/config.php');
		$this->call('config:publish', array('package' => 'jason-morton-nz/laravel-grunt'));
	}

}
