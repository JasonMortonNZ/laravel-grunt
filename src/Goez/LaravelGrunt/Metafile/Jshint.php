<?php

namespace Goez\LaravelGrunt\Metafile;

use Goez\LaravelGrunt\Metafile;

class Jshint extends Metafile
{
    /**
     * @return array
     */
    public function fileNames()
    {
        return array(
            '.jshintrc',
        );
    }

    /**
     * @return array
     */
    public function manifest()
    {
        return array(
            '.jshintrc' => static::TPL . ':jshint/jshintrc.txt',
        );
    }

}
