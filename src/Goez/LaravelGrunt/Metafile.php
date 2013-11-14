<?php

namespace Goez\LaravelGrunt;

use Illuminate\Config\Repository as Config;

abstract class Metafile
{
    const TPL = 'template';
    const DIR = 'directory';

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config = null;

    /**
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->init();
    }

    /**
     * @return void
     */
    public function init()
    {
    }

    /**
     * @param  string $path
     * @return string
     */
    public static function transPath($path)
    {
        return '/' . trim($path, '/');
    }

    /**
     * @return array
     */
    public function requirements()
    {
        return array();
    }

    /**
     * @return array
     */
    public function ignoreFiles()
    {
        return array();
    }

    /**
     * @return array
     */
    public function manifest()
    {
        return array();
    }

    /**
     * @return array
     */
    public function postCommands()
    {
        return array();
    }
}
