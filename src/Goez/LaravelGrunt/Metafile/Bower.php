<?php

namespace Goez\LaravelGrunt\Metafile;

use Goez\LaravelGrunt\Metafile;

class Bower extends Metafile
{
    /**
     * @return array
     */
    public function requires()
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
    public function fileNames()
    {
        return array(
            'bower.json',
            '.bowerrc',
        );
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
