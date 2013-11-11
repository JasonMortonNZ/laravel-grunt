<?php namespace JasonNZ\LaravelGrunt\Commands;

use Illuminate\Console\Command;

class BowerInstallCommand extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'bower:install';

    /**
     * The consolse command description
     *
     * @var string
     */
    protected $description = 'Run bower install';

    public function fire()
    {
        $this->info('Installing bower dependencies...');
        shell_exec('bower install');
    }

}
