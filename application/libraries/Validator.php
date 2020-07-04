<?php
namespace Lib;

class Validator
{
    protected static function loadTranslator()
    {
        $translation_path = APPPATH . 'language';

        $filesystem = new \Illuminate\Filesystem\Filesystem();
        $loader = new \Illuminate\Translation\FileLoader($filesystem, $translation_path);
        $loader->addNamespace('lang', $translation_path);
        $loader->load('en', 'validation', 'lang');

        return new \Illuminate\Translation\Translator($loader, 'en');
    }

    public static function __callStatic($method, $args)
    {
        $validator_factory = new \Illuminate\Validation\Factory(
            self::loadTranslator()
        );

        $CI = &get_instance();
        $CI->load->library('capsule');

        $presence = new \Illuminate\Validation\DatabasePresenceVerifier($CI->capsule->getDatabaseManager());
        $validator_factory->setPresenceVerifier($presence);

        return call_user_func_array(
            [$validator_factory, $method],
            $args
        );
    }
}
