<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit377607453fdf9a387a8e5b93dde0f648
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'League\\Plates\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'League\\Plates\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/plates/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit377607453fdf9a387a8e5b93dde0f648::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit377607453fdf9a387a8e5b93dde0f648::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
