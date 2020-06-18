<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4026827d007f8d348bc1d8c8a0a4e3d7
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit4026827d007f8d348bc1d8c8a0a4e3d7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4026827d007f8d348bc1d8c8a0a4e3d7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}