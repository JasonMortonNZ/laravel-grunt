<?php namespace JasonNZ\LaravelGrunt\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JasonNZ\LaravelGrunt\GeneratorInterface;

class GruntSetupCommand extends Command {

	/**
	 * The console command name
	 * 
	 * @var string
	 */
	protected $name = 'grunt:setup';

	/**
	 * The consolse command description
	 * 
	 * @var string
	 */
	protected $description = 'Generate a new Gruntfile.js';

	/**
	 * Path to the assets folder
	 * 
	 * @var string
	 */
	protected $assetsPath;

	/**
	 * List of user required grunt plugins
	 * 
	 * @var array
	 */
	protected $plugins = array();

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
		if(! $this->hasNode() && ! $this->hasNpm())
		{
			$this->error('It appears that either node or npm is not installed. Please install and try again!');
			exit();
		}

		// Check if a gruntfile.js or package.json already exists
		if($this->generator->filesExist())
		{
			if(! $this->askContinue())
			{
				exit();
			}
		}
		
		// Check if node and npm are installed
		$this->info('Node and NPM are installed. Continue...');
		$this->askQuestions();

		// Create package.json file & generate custom gruntfile.js
		$this->generator->generate($this->plugins);
		$this->info('package.json & gruntfile.js successfully created!');

		// Install / update modules, different command for each os type
		$this->info('Installing / updating required grunt plugins...');
		$this->installGruntPlugins();

	}

	/**
	 * Files already exist, do you want to continue?
	 * 
	 * @return boolean
	 */
	protected function askContinue()
	{
		if($this->confirm('A gruntfile.js or package.json file already exist and will be replaced. Do you want to continue? [yes|no]', false))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Ask the user which plugins they require
	 * 
	 * @return void
	 */
	protected function askQuestions()
	{
		// Do they want preprocessing?
		$this->wantPreprocessing();
	}

	/**
	 * Ask user which preprocessor they require
	 * 
	 * @return void
	 */
	protected function wantPreprocessing()
	{
		if($this->confirm('Do you require CSS preprocessing? [yes|no]', false))
		{
			// Get answer from user
			$preprocessor = strtolower($this->ask('Which CSS preprocessor do you require? [less|sass|stylus]'));

			// While answer is not valid, ask again
			while( ! $preprocessor || ! in_array($preprocessor, array('less', 'sass', 'stylus')))
			{
				$preprocessor = $this->ask('I did not recognize that preprocessor. Please try again. [less|sass|stylus]');
			}

			$this->plugins[] = $preprocessor;
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

	protected function installGruntPlugins()
	{
		shell_exec('npm install');
	}
	
}
