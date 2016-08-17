<?php
namespace App\ServiceProvider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

class Console implements ServiceProviderInterface {
    public function register(Container $container) {
        $container['console'] = function() use ($container) {
            $class = $container['console.class'];
            $instance = new $class($container['console.name'], $container['console.version']);

            if (method_exists($instance, 'setContainer')) {
                $instance->setContainer($container);
            }

            return $instance;
        };
    }
}
