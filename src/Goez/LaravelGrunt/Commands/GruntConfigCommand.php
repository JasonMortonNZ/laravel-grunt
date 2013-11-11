<?php

namespace Goez\LaravelGrunt\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;

class GruntConfigCommand extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'grunt:config';

    /**
     * The consolse command description
     *
     * @var string
     */
    protected $description = 'Copy configuration file to app/config/packages folder.';

    public function fire()
    {
        $this->info('Copied Laravel-Grunt config file to: app/config/package/goez/laravel-grunt/src/config/config.php');
        $this->call('config:publish', array('package' => 'goez/laravel-grunt'));
    }

}
