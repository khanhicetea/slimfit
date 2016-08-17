<?php

$app = app();

$app->get('/', 'Home:hello');
$app->get('/basic', 'Home:hello')->setName('basic');
