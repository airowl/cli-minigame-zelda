<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite70d0ecd605838c802de22d46f91eeee
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DemoGame\\Zelda\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DemoGame\\Zelda\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite70d0ecd605838c802de22d46f91eeee::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite70d0ecd605838c802de22d46f91eeee::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite70d0ecd605838c802de22d46f91eeee::$classMap;

        }, null, ClassLoader::class);
    }
}