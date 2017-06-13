<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc86d1c8b914147e88ebc48a8c9546bac
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Thorazine\\Hack\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Thorazine\\Hack\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc86d1c8b914147e88ebc48a8c9546bac::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc86d1c8b914147e88ebc48a8c9546bac::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}