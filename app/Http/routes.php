<?php

$app = app();

$app->get('/', 'Home:hello');
$app->get('/hello/{name}', 'Home:basic')->setName('hello');
