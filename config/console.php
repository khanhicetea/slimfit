<?php

return [
    'console.name' => 'Slimfit Console',
    'console.version' => '1.0.0',
    'console.class' => App\Console\Application::class,
    'console.commands' => [
        App\Console\Command\QuoteOfDay::class,
    ],
];
