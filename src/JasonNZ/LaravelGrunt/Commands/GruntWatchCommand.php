<?php namespace JasonNZ\LaravelGrunt\Commands;

use Illuminate\Console\Command;

class GruntWatchCommand extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'grunt:watch';

    /**
     * The console command description
     *
     * @var string
     */
    protected $description = 'Run grunt watch';

    /**
     * Fire the command
     *
     * @return void
     */
    public function fire()
    {
        $this->info('Running grunt watch....');
        shell_exec('grunt watch');
    }

}
