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
            new Metafile\Requirejs($this->config),
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

        $this->info('Generating directories and files...');

        foreach ($this->metaFiles as $metaFile) {
            /* @var $metaFile \Goez\LaravelGrunt\Metafile */
            $manifest = $metaFile->manifest();
            $files = $metaFile->fileNames();

            foreach ($manifest as $name => $type) {

                if ($this->fs->exists($name)) {
                    if (in_array($name, $files)) {
                        $message = "Overwrite file '$name'? [y|N]";

                        if ($this->confirm($message, false)) {
                            $this->generate($name, $type);
                        }
                    }
                } else {
                    $this->generate($name, $type);
                }
            }
        }

        $this->info('Installing packages...');

        $ignoreFilePath = dirname(app_path()) . '/.gitignore';
        foreach ($this->metaFiles as $metaFile) {
            /* @var $metaFile \Goez\LaravelGrunt\Metafile */

            $commands = $metaFile->postCommands();

            foreach ($commands as $command) {
                shell_exec($command);
            }

            $ignoreFiles = $metaFile->ignoreFiles();

            foreach ($ignoreFiles as $file) {
                $this->addToGitIgnore($ignoreFilePath, $file);
            }
        }


    }

    protected function checkRequirement($command, $check)
    {
        $result = shell_exec($command);
        return starts_with($result, $check);
    }

    /**
     * @param string $name
     * @param string $type
     */
    protected function generate($name, $type)
    {
        static $templateFolderPath = null;
        static $basePath = null;
        static $options = null;

        if (null === $templateFolderPath) {
            $templateFolderPath = dirname(__DIR__) . '/templates/';
        }

        if (null === $basePath) {
            $basePath = dirname(app_path());
        }

        if (null === $options) {
            $options = $this->config->get('laravel-grunt::config');
        }

        $path = $basePath . '/' . $name;
        $this->info($path);

        if ($type === Metafile::DIR) {
            if (!$this->fs->exists($path)) {
                $this->fs->makeDirectory($path, 0777, true);
            }
        } else {
            list(, $template) = explode(':', $type);
            $templatePath = $templateFolderPath . $template;
            $this->info($templatePath);

            $content = $this->fs->get($templatePath);
            $content = $this->addOptions($content, $options);
            $this->fs->put($path, $content);
        }
    }

    /**
     * Add the custom options to content
     *
     * @param  string $content
     * @param  array  $options
     * @return string
     */
    protected function addOptions($content, $options)
    {
        foreach ($options as $option => $value) {
            $pattern = '/{{\s*' . $option . '\s*}}/i';
            $content = preg_replace($pattern, $value, $content);
        }

        return $content;
    }

    /**
     * Add node_modules to .gitignore
     *
     * @param string $path
     * @param string $entry
     */
    public function addToGitIgnore($path, $entry)
    {
        $lines = array_map('trim', file($path));
        $entry = trim($entry);
        if (!in_array($entry, $lines)) {
            $lines[] = $entry;
        }
        $lines = array_unique($lines);
        $this->fs->put($path, implode("\n", $lines) . "\n");
    }

}
