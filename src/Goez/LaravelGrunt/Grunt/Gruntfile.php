<?php

namespace Goez\LaravelGrunt\Grunt;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;

class Gruntfile
{
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
     * Base path to where Gruntfile.js is to be stored
     *
     * @var string
     */
    protected $path;

    /**
     * Option names as stated in the config file
     *
     * @var array
     */
    protected $options = array(
        'assets_path',
        'publish_path',
    );

    /**
     * Constructor
     *
     * @param Filesystem $filesystem
     * @param Config     $config
     * @param string     $path
     */
    public function __construct(Filesystem $filesystem, Config $config, $path = null)
    {
        $this->filesystem = $filesystem;
        $this->config = $config;
        $this->path = $path ?: base_path();
    }

    /**
     * Create a custom gruntfile.js base upon users requirements
     *
     * @param  array $plugins
     * @return void
     */
    public function create(array $plugins)
    {
        // Get raw gruntfile.js template (without custom options)
        $rawPath = __DIR__ . '/../templates/gruntfile.txt';
        $rawContents = $this->filesystem->get($rawPath);

        // Add user specified options
        $customContent = $this->addOptions($rawContents, $this->options);

        // Generate custom default task
        $customContent = $this->addDefaultTask($customContent, $plugins);

        // Write file
        $this->writeFile($customContent, $this->getPath());
    }

    /**
     * Create default task line
     *
     * @param string $content
     * @param array  $plugins
     * @return string
     */
    protected function addDefaultTask($content, $plugins)
    {
        $pattern = "/{{tasks}}/i";
        $task = "";

        foreach ($plugins as $plugin) {
            $task .= "'" . $plugin ."', ";
        }

        $content = preg_replace($pattern, $task, $content);

        return $content;
    }

    /**
     * Add the custom options to gruntfile.js content
     *
     * @param string $content
     * @param array  $options
     * @return string
     */
    protected function addOptions($content, $options)
    {
        foreach ($options as $option) {
            $pattern = '/{{\s*' . $option . '\s*}}/i';
            $config = $this->config->get('laravel-grunt::' . $option);

            // If config item is an array, built a string from it.
            if (is_array($config)) {
                $str = $this->buildStringFromArray($config);
                $content = preg_replace($pattern, $str, $content);
            } else {
                $content = preg_replace($pattern, $config, $content);
            }
        }

        return $content;
    }

    /**
     * Write contents to the gruntfile.js
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
     * Get the path to the Gruntfile.js
     *
     * @return string
     */
    protected function getPath()
    {
        return $this->path . '/gruntfile.js';
    }

    /**
     * Build a javascript array style string from php array
     *
     * @param  array  $array
     * @return string
     */
    protected function buildStringFromArray($array)
    {
        $str = "'" . implode("','", $array) . "'";

        return $str;
    }

}
