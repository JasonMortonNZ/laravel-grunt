# Goez Laravel 4 + Grunt Asset Workflow

*This package isn't stable for production. Testing and bug reporting are welcome.*

## Features

* Includes Compass, RequireJS. (References to [generator-webapp](https://github.com/yeoman/generator-webapp) of [Yeoman](http://yeoman.io/).) 
* Helper for Laravel View.

## Installation

1. Add the following line to your composer.json `"require-dev"` array:

   `"goez/laravel-grunt": "dev-master"`

2. Run `composer update --dev` in your terminal.

3. Add the following line to the end of you `app/config.php` "providers array":

   `'Goez\LaravelGrunt\LaravelGruntServiceProvider',`

4. Run the following command to add the configuration file to your `app/config/packages` directory:

   `php artisan grunt:config`

5. You can configure the path of assets, and published files.
This configuration file is located in your project's config directory, as below:

   * `app/config/packages/goez/laravel-grunt/config.php`
   * `app/config/packages/goez/laravel-grunt/local/config.php`

6. Finally, run the following command to generate all metadata files and install packages in your app:

   `php artisan grunt:setup`

**Note 1**: You can edit the `package.json`, `bower.json`, `Grunfile.js` directly after they are generated.
   
**Note 2**: You must rerun `grunt:config` and `grunt:setup` after you update this package with composer.

## Commands

You can use `bower` and `grunt` command to manage your assets.

* `bower` to list all commands of Bower.
* `grunt --help` to list all commands of Grunt.

## Assets in view template

You can use the 'grunt_asset' helper to get asset url. Here are examples on blade template:

    <link rel="stylesheet" href="{{ grunt_asset('styles/hello.css') }}"/>
    <script src="{{ grunt_asset('styles/hello.css') }}"></script>

or:

    {{ HTML::style(grunt_asset('scripts/hello.js')) }}
    {{ HTML::script(grunt_asset('scripts/hello.js')) }}

## Bugs Report

Please report the bugs that you found to [Issus page](https://github.com/jaceju/laravel-grunt/issues) of this package.

### Contributors

- Jace Ju : [GitHub](https://github.com/jaceju)

### Original Contributors

This package is base on [JasonMortonNZ / laravel-grunt](https://github.com/JasonMortonNZ/laravel-grunt). 

Thanks to:

- Jason Morton : [Github](https://github.com/JasonMortonNZ) | [Twitter @JasonMortonNZ](https://twitter.com/jasonmortonnz)
- Thomas Clarkson : [Github](https://github.com/TomClarkson) | [Twitter @thomasclarkson9](https://twitter.com/thomasclarkson9)
