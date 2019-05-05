<?php defined('BASEPATH') or exit('No direct script access allowed');

function lang($line, $for = '', $attributes = array())
{
    $langFiles = ['en' => 'english'];
    $culture = get_lang();
    get_instance()->lang->load('message', $langFiles[$culture]);
    $line = get_instance()->lang->line($line);

    if ($culture == 'ar') {
        $line = utf8_strrev($line);
    }

    if ($for !== '') {
        $line = '<label for="' . $for . '"' . _stringify_attributes($attributes) . '>' . $line . '</label>';
    }

    return $line;
}
