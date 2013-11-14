<?php

namespace Goez\LaravelGrunt\Metafile;

use Goez\LaravelGrunt\Metafile;

class Bower extends Metafile
{
    /**
     * @return array
     */
    public function requirements()
    {
        return array(
            'bower' => array(
                'command' => 'bower -v',
                'check'   => '1',
            ),
        );
    }

    /**
     * @return array
     */
    public function ignoreFiles()
    {
        $assetsPath = $this->config->get('laravel-grunt::assets_path');

        return array(
            "/$assetsPath/vendor",
        );

    }

    /**
     * @return array
     */
    public function manifest()
    {
        return array(
            'bower.json' => static::TPL . ':bower/bower.json.txt',
            '.bowerrc' => static::TPL . ':bower/bowerrc.txt',
        );
    }

    /**
     * @return array
     */
    public function postCommands()
    {
        return array(
            'bower install',
        );
    }
}
