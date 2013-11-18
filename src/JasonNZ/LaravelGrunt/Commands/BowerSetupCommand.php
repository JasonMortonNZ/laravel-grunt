<?php namespace JasonNZ\LaravelGrunt\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JasonNZ\LaravelGrunt\GeneratorInterface;

class BowerSetupCommand extends Command {

	/**
	 * The console command name
	 * 
	 * @var string
	 */
	protected $name = 'bower:setup';

	/**
	 * The consolse command description
	 * 
	 * @var string
	 */
	protected $description = 'Generate bower.json & .bowerrc files';

	/**
	 * Path to the assets folder
	 * 
	 * @var string
	 */
	protected $assetsPath;

	/**
	 * GeneratorInterface Instance
	 * 
	 * @var GeneratorInterface
	 */
	protected $generator;

	/**
	 * Constructor
	 * 
	 * @param GeneratorInterface $generator
	 * @param Config         $config
	 */
	public function __construct(GeneratorInterface $generator, Config $config)
	{
		parent::__construct();

		$this->generator  = $generator;
		$this->assetsPath = $config->get('laravel-grunt::assets_path');
	}

	/**
	 * Execute the console command
	 * 
	 * @return void
	 */
	public function fire()
	{
		// If user has both node and npm installed continue
		if(! $this->hasNode() && ! $this->hasNpm() && ! $this->hasBower())
		{
			$this->error('It appears that either node or npm is not installed. Please install and try again!');
			exit();
		}

		// Check if a bower.json or .bowerrc already exist
		if($this->generator->filesExist())
		{
			if(! $this->askContinue())
			{
				exit();
			}
		}

		$this->generator->generate();
		$this->info('Bower - successfully setup!');
	}

	/**
	 * Files already exist, do you want to continue?
	 * 
	 * @return boolean
	 */
	protected function askContinue()
	{
		if($this->confirm('A bower.json or .bowerrc file already exist and will be replaced. Do you want to continue? [yes|no]', false))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Check if user has node installed
	 * 
	 * @return boolean
	 */
	protected function hasNode()
	{
		$node = shell_exec('node -v');

		return starts_with($node, 'v');
	}

	/**
	 * Check if user has npm (node package manager) installed
	 * 
	 * @return boolean
	 */
	protected function hasNpm()
	{
		$npm = shell_exec('npm -v');

		return starts_with($npm, '1.');
	}

	/**
	 * Check if user has bower installed
	 * 
	 * @return boolean
	 */
	protected function hasBower()
	{
		$npm = shell_exec('bower -v');

		return starts_with($npm, '1');
	}
	
}
