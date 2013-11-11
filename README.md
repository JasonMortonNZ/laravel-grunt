# Goez Laravel 4 + Grunt Asset Workflow

* Base on [Laravel 4 + Grunt Asset Workflow Package - BETA](https://github.com/JasonMortonNZ/laravel-grunt).
* Integrate workflow of [generator-webapp](https://github.com/yeoman/generator-webapp) of [Yeoman](http://yeoman.io/).

## Installation

Add the following line to your composer.json `"require-dev"` array:

`"goez/laravel-grunt": "dev-master"`

Then run `composer update --dev` in your terminal.

Next, add the following line to the end of you `app/config.php` "providers array":

`'Goez\LaravelGrunt\LaravelGruntServiceProvider',`

Finally, run the following command to add the configuration file to your `app/config/packages` directory:

`php artisan grunt:config`

## Configuration

You can configure the path of assets and published files.
This configuration file is located in your project's config directory, as below:

	app/config/packages/goez/laravel-grunt/config.php

**Note:** You can edit the `package.json` and `grunfile.js` directly when then are generated.

## How to use?

There are no more commands of this package, just use original commands of Grunt and Bower:

* `bower` to list all commands of Bower.
* `grunt --help` to list all commands of Grunt.

## Bugs Report 

Please report the bugs that you found to [Issus page](https://github.com/jaceju/laravel-grunt/issues) of this package.

### Contributors

- Jace Ju : [GitHub](https://github.com/jaceju)

### Original Contributors

- Jason Morton : [Github](https://github.com/JasonMortonNZ) | [Twitter @JasonMortonNZ](https://twitter.com/jasonmortonnz)
- Thomas Clarkson : [Github](https://github.com/TomClarkson) | [Twitter @thomasclarkson9](https://twitter.com/thomasclarkson9)
