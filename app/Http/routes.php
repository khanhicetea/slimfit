<?php

$app = app();

$app->get('/', 'Home:home')->setName('home');
$app->get('/hello/{name}', 'Home:hello')->setName('hello');
