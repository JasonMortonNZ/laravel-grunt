<?php namespace JasonNZ\LaravelGrunt\Grunt;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use JasonNZ\LaravelGrunt\GeneratorInterface;

class GruntGenerator implements GeneratorInterface {

	/**
	 * Filesystem
	 * 
	 * @var Illuminate\Filesystem
	 */
	protected $filesystem;

	/**
	 * Gruntfile
	 * 
	 * @var JasonMortonNZ\LaravelGrunt\Gruntfile
	 */
	protected $gruntfile;

	/**
	 * Config Instance
	 * 
	 * @var Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Constructor
	 * 
	 * @param Filesystem $filesystem
	 * @param Gruntfile  $gruntFile 
	 */
	public function __construct(Filesystem $filesystem, Gruntfile $gruntfile, Config $config)
	{
		$this->filesystem = $filesystem;
		$this->gruntfile = $gruntfile;
		$this->config = $config;
	}

	public function generate($plugins = null)
	{
		// Create assets folder if need
		$this->createAssetsFolder();

		// Create package.json file
		$this->createPackagefile();

		// Generate gruntfile.js
		$this->createGruntfile($plugins);

		// Add node_modules to .gitignore
		$nodeModulesPath = "\n" . "/node_modules";
		$this->addToGitingnore('.gitignore', $nodeModulesPath);
	}

	/**
	 * Create a gruntfile.js file
	 * 
	 * @param  array  $plugins
	 * @return void
	 */
	public function createGruntfile($plugins = array())
	{
		$this->gruntfile->create($plugins);
	}

	/**
	 * Create the package.json file
	 * 
	 * @return void
	 */
	public function createPackagefile()
	{
		$path = __DIR__ . "/../templates/packagefile.txt";

		// Copy content into new file called package.json in project root.
		$this->filesystem->put('package.json', $this->filesystem->get($path));
	}

	/**
	 * Create an assets folder
	 * 
	 * @param  string $path
	 * @return void
	 */
	public function createAssetsFolder()
	{
		$path = $this->config->get('laravel-grunt::assets_path');

		if( ! $this->filesystem->exists($path))
		{
			$this->filesystem->makeDirectory($path, 0777, true);
		}
	}

	/**
	 * Add node_modules to .gitignore 
	 * 
	 * @param string $path
	 * @param string $folder
	 */
	public function addToGitingnore($path, $folder)
	{
		// Check if folder already exists
		$contents = $this->filesystem->get($path);
		if ( ! str_contains($contents, $folder)) {
			$this->filesystem->append($path, $folder);
		}
	}

	/**
	 * Check if gruntfile.js and package.json already exist
	 * 
	 * @return boolean
	 */
	public function filesExist()
	{
		if($this->filesystem->exists('gruntfile.js') || $this->filesystem->exists('package.json'))
		{
			return true;
		}

		return false;
	}

}
