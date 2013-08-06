<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Assets Folder Base Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your assets
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'assets_path' => 'public/assets',

	/*
	|--------------------------------------------------------------------------
	| The CSS Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your CSS
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'css_path' => 'public/assets/css',

	/*
	|--------------------------------------------------------------------------
	| The CSS File Order
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom order in which
	| CSS files will be concatenated, compiled and minified.
	| We've set a sensible default, but feel free to update it.
	|
	*/
	'css_files' => array(
		'public/assets/css/style_one.css',
		'public/assets/css/style_two.css',
		'public/assets/css/less.css'
	),

	/*
	|--------------------------------------------------------------------------
	| The JavaScript Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your JavaScript
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'js_path' => 'public/assets/js',

	/*
	|--------------------------------------------------------------------------
	| The JavaScript File Order
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom order in which
	| JavaScript files will be concatenated, compiled and minified.
	| We've set a sensible default, but feel free to update it.
	|
	*/
	'js_files' => array(
		'public/assets/js/script_one.js',
		'public/assets/js/script_two.js'
	),

	/*
	|--------------------------------------------------------------------------
	| The LESS Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your LESS
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'less_path' => 'public/assets/less',

	/*
	|--------------------------------------------------------------------------
	| The Main LESS file
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your main LESS
	| file, which should include all imports to other LESS files.
	| We've set a sensible default, but feel free to update it.
	|
	| Note: you LESS will be compiled into a file named "less.css" in the
	| specified "css_path" above. So be sure to add it into your "css_files" array
	*/
	'less_file' => 'public/assets/less/main.less',

	/*
	|--------------------------------------------------------------------------
	| The SASS Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your SASS
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'sass_path' => 'public/assets/sass',

	/*
	|--------------------------------------------------------------------------
	| The Main SASS file
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your main SASS
	| file, which should include all imports to other SASS files.
	| We've set a sensible default, but feel free to update it.
	|
	*/
	'sass_file' => 'public/assets/sass/main.sass',

	/*
	|--------------------------------------------------------------------------
	| The Stylus Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your Stylus
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'stylus_path' => 'public/assets/stylus',

	/*
	|--------------------------------------------------------------------------
	| The Main Stylus file
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your main Stylus
	| file, which should include all imports to other Stylus files.
	| We've set a sensible default, but feel free to update it.
	|
	*/
	'stylus_file' => 'public/assets/stylus/main.stylus',

);
