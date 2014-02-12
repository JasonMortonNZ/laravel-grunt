<?php
if ( ! function_exists('get_content_type')) {
    /**
     * Get the content type of a file,
     * Returns correct content-type for common web filetypes, or 
     * uses Pecl Fileinfo (if available). Defaults to octet-stream.
     */
    function get_content_type($file) {
        $fs = new Illuminate\Filesystem\Filesystem;
        switch ($fs->extension($file)) {
        case 'jpeg': return 'image/jpeg';
        case 'jpg':  return 'image/jpeg';
        case 'jpe':  return 'image/jpeg';
        case 'gif':  return 'image/gif';
        case 'png':  return 'image/x-png';
        case 'css':  return 'text/css';
        case 'js':   return 'application/x-javascript';
        default:     
            if (class_exists('finfo')) {
                $finfo = new finfo(FILEINFO_MIME);
                return $finfo->file($file);
            } else {
                return 'application/octet-stream';
            }
        }
    }
}

$path = Config::get("laravel-grunt::assets_path");
Route::get("$path/{filename?}", function ($filename) use ($path) {
    $fs = new Illuminate\Filesystem\Filesystem;
    $fullpath = base_path() . "/$path/$filename";
    $tmppath = base_path() . "/tmp/$path/$filename";
    if ($fs->exists($fullpath)) {
        return Response::make($fs->get($fullpath))
            ->header('Content-Type', get_content_type($fullpath));
    } else if ($fs->exists($tmppath)) {
        return Response::make($fs->get($tmppath))
            ->header('Content-Type', get_content_type($tmppath));
    } else {
        return App::abort(404);
    }
})->where('filename', '.+');
