<?php

namespace Goez\LaravelGrunt\Metafile;

use Goez\LaravelGrunt\Metafile;

class Jshint extends Metafile
{
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
    public function fileNames()
    {
        return array(
            '.jshintrc',
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
            '.jshintrc' => static::TPL . ':jshint/jshintrc.txt',
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
