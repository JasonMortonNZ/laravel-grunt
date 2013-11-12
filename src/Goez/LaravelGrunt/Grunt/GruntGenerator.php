<?php

namespace Goez\LaravelGrunt\Grunt;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Goez\LaravelGrunt\GeneratorInterface;

class GruntGenerator implements GeneratorInterface
{
    /**
     * Filesystem
     *
     * @var \Illuminate\Filesystem\FileSystem
     */
    protected $filesystem;

    /**
     * Gruntfile
     *
     * @var \Goez\LaravelGrunt\Grunt\Gruntfile
     */
    protected $gruntfile;

    /**
     * Config Instance
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $assetsPath = '';

    /**
     * Constructor
     *
     * @param Filesystem $filesystem
     * @param Gruntfile  $gruntfile
     * @param Config     $config
     */
    public function __construct(Filesystem $filesystem, Gruntfile $gruntfile, Config $config)
    {
        $this->filesystem = $filesystem;
        $this->gruntfile = $gruntfile;
        $this->config = $config;
        $this->assetsPath = '/' . trim($this->config->get('laravel-grunt::assets_path'), '/');
    }

    public function generate($plugins = null)
    {
        // Create assets folder if need
        $this->createAssetsFolder();

        // Create package.json file
        $this->createPackagefile();

        // Create .jshintrc file
        $this->createJsHintRcfile();

        // Generate Gruntfile.js
        $this->createGruntfile($plugins);

        // Add folders to .gitignore
        $this->processGitIgnore();
    }

    /**
     * Create a Gruntfile.js file
     *
     * @param  array $plugins
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
        $path = __DIR__ . "/../templates/packagejson.txt";

        // Copy content into new file called package.json in project root.
        $this->filesystem->put('package.json', $this->filesystem->get($path));
    }

    /**
     * Create the .jshintrc file
     * @return void
     */
    public function createJsHintRcfile()
    {
        $path = __DIR__ . "/../templates/jshintrc.txt";

        // Copy content into new file called package.json in project root.
        $this->filesystem->put('.jshintrc', $this->filesystem->get($path));
    }

    /**
     * Create an assets folder
     * @return void
     */
    public function createAssetsFolder()
    {
        $basePath = dirname(app_path()) . $this->assetsPath;

        $paths = array(
            $basePath,
            $basePath . '/scripts',
            $basePath . '/styles',
            $basePath . '/images',
            $basePath . '/vendor',
        );

        foreach ($paths as $path) {
            if (!$this->filesystem->exists($path)) {
                $this->filesystem->makeDirectory($path, 0777, true);
            }
        }
    }

    public function processGitIgnore()
    {
        $paths = array(
            $this->assetsPath . '/vendor',
            "/node_modules",
        );

        foreach ($paths as $path) {
            $this->addToGitIgnore('.gitignore', $path);
        }
    }

    /**
     * Add node_modules to .gitignore
     *
     * @param string $path
     * @param string $folder
     */
    public function addToGitIgnore($path, $folder)
    {
        $lines = array_map('trim', file($path));
        $folder = trim($folder);
        if (!in_array($folder, $lines)) {
            $lines[] = $folder;
        }
        $lines = array_unique($lines);
        $this->filesystem->put($path, implode("\n", $lines) . "\n");
    }

    /**
     * Check if Gruntfile.js and package.json already exist
     *
     * @return boolean
     */
    public function filesExist()
    {
        return ($this->filesystem->exists('Gruntfile.js')
            || $this->filesystem->exists('package.json'));
    }

    /**
     * @return array
     */
    public function getFilenames()
    {
        return array('Gruntfile.js', 'package.json', '.jshintrc');
    }

}
