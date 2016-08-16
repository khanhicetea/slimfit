<?php
namespace App\ServiceProvider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;

class Console extends ServiceProviderInterface {
    public function register(Container $container) {
        foreach ($this->getDefaults() as $key => $value) {
            if (!isset($container[$key])) {
                $container[$key] = $value;
            }
        }

        $container['console'] = function() use ($container) {
            $class = $container['console.class'];
            $instance = new $class($container['console.name'], $container['console.version']);

            if (method_exists($instance, 'setContainer')) {
                $instance->setContainer($container);
            }

            return $instance;
        };
    }

    protected function getDefaults()
    {
        return [
            'console.name'    => 'Console Application',
            'console.class'   => 'Symfony\Component\Console\Application',
            'console.version' => '1.0.0',
        ];
    }
}
