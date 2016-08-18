<?php

$app = require __DIR__.'/../bootstrap/app.php';
$http_kernel = $app->getContainer()->get('kernel');
$http_kernel->boot();
