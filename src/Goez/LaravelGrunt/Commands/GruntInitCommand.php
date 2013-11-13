<?php

namespace Goez\LaravelGrunt\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Goez\LaravelGrunt\Metafile;

class GruntInitCommand extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'grunt:init';

    /**
     * The console command description
     *
     * @var string
     */
    protected $description = 'Generate directories and files for Grunt.';

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $fs = null;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config = null;

    /**
     * @var array
     */
    protected $metaFiles = array();

    /**
     * Constructor
     *
     * @param \Illuminate\Filesystem\Filesystem $fs
     * @param \Illuminate\Config\Repository     $config
     */
    public function __construct(Filesystem $fs, Config $config)
    {
        $this->fs = $fs;
        $this->config = $config;
        parent::__construct();
    }

    protected function initMetafiles()
    {
        $this->metaFiles = array(
            new Metafile\Grunt($this->config),
            new Metafile\Bower($this->config),
            new Metafile\Jshint($this->config),
            new Metafile\Mocha($this->config),
            new Metafile\Assets($this->config),
        );
    }

    /**
     * Execute the console command
     *
     * @return void
     */
    public function fire()
    {
        $this->initMetafiles();

        $this->info('Checking requirements...');

        foreach ($this->metaFiles as $metaFile) {
            /* @var $metaFile \Goez\LaravelGrunt\Metafile */
            $requirements = $metaFile->requirements();
            foreach ($requirements as $target => $c) {
                $result = $this->checkRequirement($c['command'], $c['check']);

                $message = "$target ... " . ($result ? "yes" : "no");
                $this->info($message);

                if (!$result) {
                    $this->error("$target is not installed.");
                    return;
                }
            }
        }

        $this->info('Overwrite files?');

        $rootPath = dirname(app_path());

        foreach ($this->metaFiles as $metaFile) {
            /* @var $metaFile \Goez\LaravelGrunt\Metafile */
            $files = $metaFile->fileNames();

            foreach ($files as $file) {
                // $entry = $rootPath . Metafile::transPath($file);

                if ($this->fs->exists($file)) {
                    $message = "Replace file '$file'? [y|n]";

                    if ($this->confirm($message, false)) {
                        $this->info("'$file' be replaced.");
                    }
                }

            }

        }

        $this->info('Generating directories and files...');

//        // Check if a gruntfile.js or package.json already exists
//        foreach ($this->generators as $generator)
//        if ($generator->filesExist()) {
//            if (! $this->askContinue($generator)) {
//                return;
//            }
//        }
//
//        // Check if node and npm are installed
//        $this->info('Node and NPM are installed. Continue...');
//        $this->askQuestions();
//
//        // Create package.json file & generate custom gruntfile.js
//        foreach ($this->generators as $generator) {
//            $generator->generate($this->plugins);
//        }
//        $this->info('Metadata files successfully created!');
//
//        $this->info('Install bower dependences...');
//        $this->installBowerDependences();
//
//        $this->info('Installing / updating required grunt plugins...');
//        $this->installGruntPlugins();

    }

    protected function checkRequirement($command, $check)
    {
        $result = shell_exec($command);
        return starts_with($result, $check);
    }

//    /**
//     * Files already exist, do you want to continue?
//     *
//     * @param  GeneratorInterface $generator
//     * @return boolean
//     */
//    protected function askContinue(GeneratorInterface $generator)
//    {
//        $filenames = $generator->getFilenames();
//
//        return ($this->confirm(
//            'A ' . implode(' or ', $filenames) .
//            ' file already exist and will be replaced.' .
//            ' Do you want to continue? [y|n]', false));
//    }
//
//    /**
//     * Ask the user which plugins they require
//     *
//     * @return void
//     */
//    protected function askQuestions()
//    {
//        // Do they want preprocessing?
//        $this->wantPreprocessing();
//    }
//
//    /**
//     * Ask user which preprocessor they require
//     *
//     * @return void
//     */
//    protected function wantPreprocessing()
//    {
//        if ($this->confirm('Do you require CSS preprocessing? [y|n]', false)) {
//            // Get answer from user
//            $preprocessor = strtolower($this->ask('Which CSS preprocessor do you require? [less|sass|stylus]'));
//
//            // While answer is not valid, ask again
//            while ( ! $preprocessor || ! in_array($preprocessor, array('less', 'sass', 'stylus'))) {
//                $preprocessor = $this->ask('I did not recognize that preprocessor. Please try again. [less|sass|stylus]');
//            }
//
//            $this->plugins[] = $preprocessor;
//        }
//    }
//
//    /**
//     * Check if user has node installed
//     *
//     * @return boolean
//     */
//    protected function hasNode()
//    {
//        $node = shell_exec('node -v');
//
//        return starts_with($node, 'v');
//    }
//
//    /**
//     * Check if user has npm (node package manager) installed
//     *
//     * @return boolean
//     */
//    protected function hasNpm()
//    {
//        $npm = shell_exec('npm -v');
//
//        return starts_with($npm, '1.');
//    }
//
//    /**
//     * Check if user has bower installed
//     *
//     * @return boolean
//     */
//    protected function hasBower()
//    {
//        $bower = shell_exec('bower -v');
//
//        return starts_with($bower, '1');
//    }
//
//    protected function installBowerDependencies()
//    {
//        shell_exec('bower install');
//    }
//
//    protected function installGruntPlugins()
//    {
//        shell_exec('npm install');
//    }

}
