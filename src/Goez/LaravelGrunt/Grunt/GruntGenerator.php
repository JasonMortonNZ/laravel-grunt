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

        // Add node_modules to .gitignore
        $nodeModulesPath = "/node_modules";
        $this->addToGitingnore('.gitignore', $nodeModulesPath);
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
        $path = __DIR__ . "/../templates/packagefile.txt";

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
        $path = $this->config->get('laravel-grunt::assets_path');

        if (!$this->filesystem->exists($path)) {
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
        $lines = array_map('trim', file($path));
        if (!in_array(trim($folder), $lines)) {
            $this->filesystem->append($path, $folder);
        }
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
