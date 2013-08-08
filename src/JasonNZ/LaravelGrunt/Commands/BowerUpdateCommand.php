<?php namespace JasonNZ\LaravelGrunt\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BowerUpdateCommand extends Command {

	/**
	 * The console command name
	 * 
	 * @var string
	 */
	protected $name = 'bower:update';

	/**
	 * The consolse command description
	 * 
	 * @var string
	 */
	protected $description = 'Run bower update';

	public function fire()
	{
		$this->info('Updating bower dependencies...');
		shell_exec('bower update');
	}

}