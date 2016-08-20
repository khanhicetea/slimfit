<?php

$app = require __DIR__.'/bootstrap/app.php';

$dsn = sprintf('%s:dbname=%s;host=%s;charset=%s', env('DB_DRIVER'), env('DB_DATABASE'),
    env('DB_HOST'), env('DB_CHARSET', 'utf8'));
$pdo = new PDO($dsn, env('DB_USERNAME'), env('DB_PASSWORD'));

return [
    'paths' => [
        'migrations' => realpath(__DIR__.'/db/migrations'),
        'seeds' => realpath(__DIR__.'/db/seeds'),
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'default',
        'default' => [
            'name' => env('DB_DATABASE'),
            'connection' => $pdo,
        ],
    ],
];
