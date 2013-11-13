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
    }

    /**
     * @param string $path
     * @return string
     */
    public static function transPath($path)
    {
        return '/' . trim($path, '/');
    }

    /**
     * @return array
     */
    public function checkEnv()
    {
        return array();
    }

    /**
     * @return array
     */
    public function requires()
    {
        return array();
    }

    /**
     * @return array
     */
    public function preCommands()
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
