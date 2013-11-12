<?php

namespace Goez\LaravelGrunt\Bower;

use \Illuminate\Filesystem\Filesystem;
use \Illuminate\Config\Repository as Config;
use Goez\LaravelGrunt\GeneratorInterface;

class BowerGenerator implements GeneratorInterface
{
    /**
     * Filesystem
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * GruntFile
     *
     * @var \Goez\LaravelGrunt\Bower\Bowerfile
     */
    protected $bowerFile;

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
     * @param Bowerfile  $bowerFile
     * @param Config     $config
     */
    public function __construct(Filesystem $filesystem, Bowerfile $bowerFile, Config $config)
    {
        $this->filesystem = $filesystem;
        $this->bowerFile = $bowerFile;
        $this->config = $config;
        $this->assetsPath = $this->config->get('laravel-grunt::assets_path');
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
     * @return void
     */
    public function createVendorFolder()
    {
        $path = $this->assetsPath . '/vendor';

        if ( ! $this->filesystem->exists($path)) {
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
        return ($this->filesystem->exists($this->assetsPath . '/bower.json')
            || $this->filesystem->exists($this->assetsPath . '/.bowerrc'));

    }

}
