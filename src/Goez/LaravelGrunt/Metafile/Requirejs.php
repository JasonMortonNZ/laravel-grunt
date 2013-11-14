<?php

namespace Goez\LaravelGrunt\Metafile;

use Goez\LaravelGrunt\Metafile;

class Requirejs extends Metafile
{

    /**
     * @var string
     */
    protected $assetsPath = '';

    /**
     * @return void
     */
    public function init()
    {
        $this->assetsPath = $this->config->get('laravel-grunt::assets_path');
    }

    /**
     * @return array
     */
    public function manifest()
    {
        return array(
            $this->assetsPath . '/scripts' => static::DIR,
            $this->assetsPath . '/scripts/app.js' => static::TPL . ':requirejs/app.js.txt',
            $this->assetsPath . '/scripts/main.js' => static::TPL . ':requirejs/main.js.txt',
        );
    }

}
