<?php namespace JasonNZ\LaravelGrunt\Bower;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use JasonNZ\LaravelGrunt\Bower\Bowerfile;
use JasonNZ\LaravelGrunt\GeneratorInterface;

class BowerGenerator implements GeneratorInterface {

	/**
	 * Filesystem
	 * 
	 * @var Illuminate\Filesystem
	 */
	protected $filesystem;

	/**
	 * GruntFile
	 * 
	 * @var JasonMortonNZ\LaravelGrunt\Bower\Bowerfile
	 */
	protected $bowerFile;

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
	 * @param Bowerfile  $bowerFile 
	 */
	public function __construct(Filesystem $filesystem, Bowerfile $bowerFile, Config $config)
	{
		$this->filesystem = $filesystem;
		$this->bowerFile = $bowerFile;
		$this->config = $config;
	}

	public function generate()
	{
		// vendore folder
		$this->createVendorFolder();

		// bowerrc
		$this->createBowerRcFile();

		// bower.json
		$this->createBowerJsonFile();
	}

	/**
	 * Create a bower.json file
	 * 
	 * @return void
	 */
	public function createBowerJsonFile()
	{
		$this->bowerFile->createBowerJsonFile();
	}

	/**
	 * Create the .bowerrc file
	 * 
	 * @return void
	 */
	public function createBowerRcFile()
	{
		$this->bowerFile->createBowerRcFile();
	}

	/**
	 * Create an assets folder
	 * 
	 * @param  string $path
	 * @return void
	 */
	public function createVendorFolder()
	{
		$path = $this->config->get('laravel-grunt::vendor_path');

		if( ! $this->filesystem->exists($path))
		{
			$this->filesystem->makeDirectory($path, 0777, true);
		}
	}

	/**
	 * Check if bower.json and .bowerrc already exist
	 * 
	 * @return boolean
	 */
	public function filesExist()
	{
		if($this->filesystem->exists($this->config->get('laravel-grunt::assets_path') . '/bower.json') || $this->filesystem->exists($this->config->get('laravel-grunt::assets_path') . '/.bowerrc'))
		{
			return true;
		}

		return false;
	}

}
