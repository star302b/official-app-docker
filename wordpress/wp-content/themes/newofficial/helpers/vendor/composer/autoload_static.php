<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit120a41783b372516721ec43f3c572768
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BabyMarkt\\DeepL\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BabyMarkt\\DeepL\\' => 
        array (
            0 => __DIR__ . '/..' . '/babymarkt/deepl-php-lib/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit120a41783b372516721ec43f3c572768::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit120a41783b372516721ec43f3c572768::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit120a41783b372516721ec43f3c572768::$classMap;

        }, null, ClassLoader::class);
    }
}
