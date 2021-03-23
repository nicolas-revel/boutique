<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit916d3698b1e8f2332357af0caa9f9ad0
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\views\\components\\' => 21,
            'app\\' => 4,
        ),
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\views\\components\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Views',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
            1 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Parsedown' => 
            array (
                0 => __DIR__ . '/..' . '/erusev/parsedown',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit916d3698b1e8f2332357af0caa9f9ad0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit916d3698b1e8f2332357af0caa9f9ad0::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit916d3698b1e8f2332357af0caa9f9ad0::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit916d3698b1e8f2332357af0caa9f9ad0::$classMap;

        }, null, ClassLoader::class);
    }
}
