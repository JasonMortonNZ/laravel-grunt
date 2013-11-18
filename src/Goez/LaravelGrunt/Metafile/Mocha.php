<?php

namespace Goez\LaravelGrunt\Metafile;

use Goez\LaravelGrunt\Metafile;

class Mocha extends Metafile
{
    /**
     * @return array
     */
    public function manifest()
    {
        return array(
            'test' => static::DIR,
            'test/lib' => static::DIR,
            'test/index.html' => static::TPL . ':mocha/index.html.txt',
            'test/lib/chai.js' => static::TPL . ':mocha/lib/chai.js.txt',
            'test/lib/expect.js' => static::TPL . ':mocha/lib/expect.js.txt',
            'test/lib/mocha' => static::DIR,
            'test/lib/mocha/mocha.css' => static::TPL . ':mocha/lib/mocha/mocha.css.txt',
            'test/lib/mocha/mocha.js' => static::TPL . ':mocha/lib/mocha/mocha.js.txt',
            'test/spec' => static::DIR,
            'test/spec/test.js' => static::TPL . ':mocha/spec/test.js.txt',
        );
    }
}
