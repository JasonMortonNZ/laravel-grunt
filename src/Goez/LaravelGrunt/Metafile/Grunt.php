<?php

namespace Goez\LaravelGrunt\Metafile;

use Goez\LaravelGrunt\Metafile;

class Grunt extends Metafile
{

    /**
     * @return array
     */
    public function requires()
    {
        return array(
            'node' => array(
                'command' => 'node -v',
                'check'   => 'v',
            ),
            'npm' => array(
                'command' => 'npm -v',
                'check'   => '1.',
            ),
        );
    }

    /**
     * @return array
     */
    public function fileNames()
    {
        return array(
            'Gruntfile.js',
            'package.json',
        );
    }

    /**
     * @return array
     */
    public function manifest()
    {
        return array(
            'Gruntfile.js' => static::TPL . ':grunt/Gruntfile.js.txt',
            'package.json' => static::TPL . ':grunt/package.json.txt',
        );
    }

    /**
     * @return array
     */
    public function postCommands()
    {
        return array(
            'npm install',
        );
    }
}
