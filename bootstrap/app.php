<?php

$autoloader = require __DIR__.'/autoload.php';
require_once __DIR__.'/helpers.php';

$dotenv = new Dotenv\Dotenv(dirname(__DIR__));
$dotenv->load();

$app = App\SlimFit::init([
    'settings' => [
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
    'storage_path' => realpath(__DIR__.'/../storage'),
    'public_path' => realpath(__DIR__.'/../public'),
]);

// Register service providers
$service_providers = [
];

foreach ($service_providers as $service_provider) {
    $app->register(new $service_provider());
}

return $app;
