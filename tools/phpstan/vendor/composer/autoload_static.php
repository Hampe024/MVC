<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita652e04a1f12ca147edab2fe45e5ea3a
{
    public static $files = array (
        '9b38cf48e83f5d8f60375221cd213eee' => __DIR__ . '/..' . '/phpstan/phpstan/bootstrap.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInita652e04a1f12ca147edab2fe45e5ea3a::$classMap;

        }, null, ClassLoader::class);
    }
}