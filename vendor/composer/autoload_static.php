<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitadfa9ca4d9f9f12926f1620422b5e1e8
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitadfa9ca4d9f9f12926f1620422b5e1e8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitadfa9ca4d9f9f12926f1620422b5e1e8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitadfa9ca4d9f9f12926f1620422b5e1e8::$classMap;

        }, null, ClassLoader::class);
    }
}
