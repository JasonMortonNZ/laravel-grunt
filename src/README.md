# Laravel 4 + Grunt Asset Workflow Package

## Contents

- What this package includes and can do?
- Installation
- How to use?
- Issues - how to help

### What this package includes and can do?
This package is design to help with asset management and front-end workflow when developing in Laravel 4.

The package can do the following:

- compile and minify CSS
- compile and minify JavaScript
- compile LESS
- compile SASS
- compile Stylus
- build all asset group with one command
- Live reload (watches asset files for changes and reloads the browser)

### Installation
To install the 'Laravel 4 + Grunt Asset Workflow Package' simply add the following to your composer.json `"require-dev"` array:

`"JasonMortonNZ/LaravelGrunt": "dev-master"`

### How to use?
So, how do you use this package? Well we've tried to make it as simple as possible. There's just 3 commands:

#### grunt:setup
The `grunt:setup` command is used to setup your required asset + grunt workflow. You use the command as follows:

`php artisan grunt:setup`

The command will ask you a selection of questions, and the rest is all done for you.

#### grunt:build
The `grunt:build` command will run the grunt task runner and lint, compile, minify all your files, according to how you want things done. You use the command as follows:

`php artisan grunt:build`

#### grunt:watch
The `grunt:watch` command is used to start a the grunt file watcher. This will watch for any changes made to your front-end workflow files (CSS, JavaScript, LESS, SASS & Stylus), and will then auto-reload your web browser to reflect those changes. You can use the command as follows:

`php artisan grunt:watch`

**Note:** That live reload will only work if you have a compatible browser (Chrome & Firefox) with the LiveReload plugin installed.

## Issues - how to help?
If you find any bugs, issues errors or believe we could add further useful functionality. Let us know via the github issues page for this project.
