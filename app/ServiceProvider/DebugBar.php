<?php
namespace App\ServiceProvider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use DebugBar\StandardDebugBar;
use App\Http\Kernel;
use Psr7Middlewares\Middleware;
use App\Lib\PHPDebugBarEloquentCollector;

class DebugBar implements ServiceProviderInterface {
    public function register(Container $container) {
        $container['debug_bar'] = function($c) {
            $debug_bar = new StandardDebugBar();
            $debug_bar->addCollector(new PHPDebugBarEloquentCollector($c['capsule']));

            return $debug_bar;
        };

        $container['kernel'] = $container->extend('kernel', function (Kernel $kernel, $c) {
            $kernel->appendAppMiddleware(Middleware::FormatNegotiator()->defaultFormat('html'));
            $kernel->appendAppMiddleware(Middleware::DebugBar($c['debug_bar']));

            return $kernel;
        });
    }
}
