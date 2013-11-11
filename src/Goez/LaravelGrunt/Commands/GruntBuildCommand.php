<?php

namespace Goez\LaravelGrunt\Commands;

use Illuminate\Console\Command;

class GruntBuildCommand extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'grunt:build';

    /**
     * The consolse command description
     *
     * @var string
     */
    protected $description = 'Run grunt';

    public function fire()
    {
        $this->info('Running grunt...and rebuilding assets.');
        shell_exec('grunt');
    }

}
