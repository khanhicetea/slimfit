<?php

namespace App\ServiceProvider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\StreamHandler;
use App\Lib\ErrorHandler;

class Monolog implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['logger'] = function ($c) {
            $settings = $c->get('settings');
            $logger = new Logger($settings['logger']['name']);
            $logger->pushHandler(new StreamHandler($settings['logger']['path'], $settings['logger']['level']));

            return $logger;
        };

        $container['errorHandler'] = function ($c) {
            return new ErrorHandler($c->get('settings')['displayErrorDetails'], $c['logger']);
        };
    }
}
