<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('imagePath')) {
    function imagePath($filename = '')
    {
        return "assets/uploads/images/{$filename}";
    }
}

if (!function_exists('imageBasePath')) {
    function imageBasePath($filename = '')
    {
        return site_url(imagePath($filename));
    }
}
