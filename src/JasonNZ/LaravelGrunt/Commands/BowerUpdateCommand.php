<?php namespace JasonNZ\LaravelGrunt\Commands;

use Illuminate\Console\Command;

class BowerUpdateCommand extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'bower:update';

    /**
     * The consolse command description
     *
     * @var string
     */
    protected $description = 'Run bower update';

    public function fire()
    {
        $this->info('Updating bower dependencies...');
        shell_exec('bower update');
    }

}
