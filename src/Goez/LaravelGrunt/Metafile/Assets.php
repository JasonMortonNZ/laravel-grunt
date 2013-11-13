<?php

namespace Goez\LaravelGrunt\Metafile;

use Goez\LaravelGrunt\Metafile;

class Assets extends Metafile
{
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
    public function fileNames()
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
        $assetsPath = static::transPath($this->config->get('laravel-grunt:assets_path'));

        return array(
            $assetsPath . '/images' => static::DIR,
            $assetsPath . '/scripts' => static::DIR,
            $assetsPath . '/styles' => static::DIR,
            $assetsPath . '/index.html' => static::TPL . ':assets/index.html.txt',
        );
    }

    /**
     * @return array
     */
    public function postCommands()
    {
        return array();
    }
}
