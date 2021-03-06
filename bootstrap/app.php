<?php

$autoloader = require __DIR__.'/autoload.php';
require_once __DIR__.'/helpers.php';

$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

$app = App\SlimFit::init([
    'settings' => [
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => env('DEBUG', false),
        'logger' => [
            'name' => env('APP_NAME', 'slimfit'),
            'level' => env('DEBUG', false) ? Monolog\Logger::DEBUG : Monolog\Logger::ERROR,
            'path' => __DIR__.'/../storage/log/app.log',
        ],
    ],
    'autoloader' => $autoloader,
    'root_path' => dirname(__DIR__),
    'app_path' => realpath(__DIR__.'/../app'),
    'config_path' => realpath(__DIR__.'/../config'),
    'storage_path' => realpath(__DIR__.'/../storage'),
    'resources_path' => realpath(__DIR__.'/../resources'),
    'public_path' => realpath(__DIR__.'/../public'),
]);

// Register service providers
$service_providers = [
    App\ServiceProvider\Monolog::class => [],
    App\ServiceProvider\HttpKernel::class => [],

    /* Twig template engine */
    // App\ServiceProvider\Twig::class => ['view.cache' => env('TWIG_CACHE', false)],

    /* Eloquent */
    // App\ServiceProvider\Capsule::class => app('config.database'),

    /* DebugBar */
    // App\ServiceProvider\DebugBar::class => [],
];

foreach ($service_providers as $service_provider => $opts) {
    $app->register(new $service_provider(), $opts);
}

return $app;
