<?php namespace JasonNZ\LaravelGrunt\Bower;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;

class Bowerfile {

	/**
	 * Filesystem Instance
	 *
	 * @var Illuminate\Filesystem\Filesystem
	 */
	protected $filesystem;

	/**
	 * Config Instance
	 *
	 * @var Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Base path to where bower.json is to be stored
	 *
	 * @var string
	 */
	protected $path;

	/**
	 * Option names as stated in the config file
	 * 
	 * @var array
	 */
	protected $options = array('vendor_path', 'bower_dependencies');

	/**
	 * Constructor
	 * 
	 * @param Filesystem $filesystem
	 * @param Config       $config
	 * @param string        $path
	 */
	public function __construct(Filesystem $filesystem, Config $config, $path = null)
	{
		$this->filesystem = $filesystem;
		$this->config = $config;
		$this->path = $path ?: $this->config->get('laravel-grunt::assets_path');
	}

	/**
	 * Create a custom bower.json base upon users requirements
	 * 
	 * @return void
	 */
	public function createBowerJsonFile()
	{
		// Get raw bower.json template (without custom options)
		$rawPath = __DIR__ . '/../templates/bowerjson.txt';
		$rawContents = $this->filesystem->get($rawPath);

		// Add user specified options
		$customContent = $this->addOptions($rawContents, $this->options);

		// Write file
		$this->writeFile($customContent, 'bower.json');
	}

	/**
	 * Create a .bowerrc file
	 * 
	 * @return void
	 */
	public function createBowerRcFile()
	{
		$rawPath = __DIR__ . "/../templates/bowerrc.txt";
		$rawContents = $this->filesystem->get($rawPath);

		// Add user specified options
		$customContent = $this->addOptions($rawContents, $this->options);

		// Write file
		$this->writeFile($customContent, '.bowerrc');
	}

	/**
	 * Add the custom options to bower.json content
	 * 
	 * @param string $content
	 * @param array $plugins
	 */
	protected function addOptions($content, $options)
	{
		foreach ($options as $option)
		{
			$pattern = '/{{' . $option . '}}/i';
			$config = $this->config->get('laravel-grunt::' . $option);

			// If config item is an array, built a JSON style array string from it.
			if(is_array($config))
			{
				$str = $this->buildJSONStringFromArray($config);
				$content = preg_replace($pattern, $str, $content);
			} else {
				$content = preg_replace($pattern, $config, $content);
			}
		}
		return $content;
	}

	/**
	 * Write contents to the bower.json
	 * 
	 * @param  string $content
	 * @param  string $path
	 * @return void
	 */
	protected function writeFile($content, $path)
	{
		$this->filesystem->put($path, $content);
	}

	/**
	 * Get the path to the bower.json
	 *
	 * @return string
	 */
	protected function getPath()
	{
		return $this->path . '/bower.json';
	}

	/**
	 * Build a javascript array style string from php array
	 * 
	 * @param  array $array
	 * @return string
	 */
	protected function buildJSONStringFromArray($array)
	{
		$str = '';
		foreach ($array as $key => $value) {
			$str .= '"' . $key . '": "' . $value .'",';
		}

		return rtrim($str, ",");
	}

}
