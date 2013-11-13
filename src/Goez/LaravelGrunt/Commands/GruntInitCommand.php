<?php

namespace Goez\LaravelGrunt\Commands;

use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Goez\LaravelGrunt\GeneratorInterface;

class GruntSetupCommand extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'grunt:setup';

    /**
     * The consolse command description
     *
     * @var string
     */
    protected $description = 'Generate metadata files for Grunt.';

    /**
     * Path to the assets folder
     *
     * @var string
     */
    protected $assetsPath;

    /**
     * List of user required grunt plugins
     *
     * @var array
     */
    protected $plugins = array();

    /**
     * GeneratorInterface Instance
     *
     * @var GeneratorInterface
     */
    protected $generator;

    /**
     * @var array
     */
    protected $generators = array();

    /**
     * Constructor
     *
     * @param array  $generators
     * @param Config $config
     */
    public function __construct($generators, Config $config)
    {
        parent::__construct();

        $this->generators = $generators;
        $this->assetsPath = $config->get('laravel-grunt::assets_path');
    }

    /**
     * Execute the console command
     *
     * @return void
     */
    public function fire()
    {
        // If user has both node and npm installed continue
        if (!$this->hasNode() && !$this->hasNpm() && !$this->hasBower()) {
            $this->error('It appears that either node or npm is not installed. Please install and try again!');

            return;
        }

        // Check if a gruntfile.js or package.json already exists
        foreach ($this->generators as $generator)
        if ($generator->filesExist()) {
            if (! $this->askContinue($generator)) {
                return;
            }
        }

        // Check if node and npm are installed
        $this->info('Node and NPM are installed. Continue...');
        $this->askQuestions();

        // Create package.json file & generate custom gruntfile.js
        foreach ($this->generators as $generator) {
            $generator->generate($this->plugins);
        }
        $this->info('Metadata files successfully created!');

        $this->info('Install bower dependences...');
        $this->installBowerDependences();

        $this->info('Installing / updating required grunt plugins...');
        $this->installGruntPlugins();

    }

    /**
     * Files already exist, do you want to continue?
     *
     * @param  GeneratorInterface $generator
     * @return boolean
     */
    protected function askContinue(GeneratorInterface $generator)
    {
        $filenames = $generator->getFilenames();

        return ($this->confirm(
            'A ' . implode(' or ', $filenames) .
            ' file already exist and will be replaced.' .
            ' Do you want to continue? [y|n]', false));
    }

    /**
     * Ask the user which plugins they require
     *
     * @return void
     */
    protected function askQuestions()
    {
        // Do they want preprocessing?
        $this->wantPreprocessing();
    }

    /**
     * Ask user which preprocessor they require
     *
     * @return void
     */
    protected function wantPreprocessing()
    {
        if ($this->confirm('Do you require CSS preprocessing? [y|n]', false)) {
            // Get answer from user
            $preprocessor = strtolower($this->ask('Which CSS preprocessor do you require? [less|sass|stylus]'));

            // While answer is not valid, ask again
            while ( ! $preprocessor || ! in_array($preprocessor, array('less', 'sass', 'stylus'))) {
                $preprocessor = $this->ask('I did not recognize that preprocessor. Please try again. [less|sass|stylus]');
            }

            $this->plugins[] = $preprocessor;
        }
    }

    /**
     * Check if user has node installed
     *
     * @return boolean
     */
    protected function hasNode()
    {
        $node = shell_exec('node -v');

        return starts_with($node, 'v');
    }

    /**
     * Check if user has npm (node package manager) installed
     *
     * @return boolean
     */
    protected function hasNpm()
    {
        $npm = shell_exec('npm -v');

        return starts_with($npm, '1.');
    }

    /**
     * Check if user has bower installed
     *
     * @return boolean
     */
    protected function hasBower()
    {
        $bower = shell_exec('bower -v');

        return starts_with($bower, '1');
    }

    protected function installBowerDependences()
    {
        shell_exec('bower install');
    }

    protected function installGruntPlugins()
    {
        shell_exec('npm install');
    }

}
