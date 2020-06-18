<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit16df378a231bf743ad4bf1f88805760e
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Khipu\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Khipu\\' => 
        array (
            0 => __DIR__ . '/..' . '/khipu/khipu-api-client/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit16df378a231bf743ad4bf1f88805760e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit16df378a231bf743ad4bf1f88805760e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
