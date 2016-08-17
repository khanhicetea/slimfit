<?php

namespace App\ServiceProvider;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Cache\CacheManager;
use Illuminate\Database\Capsule\Manager;

class Eloquent implements ServiceProviderInterface
{
    /**
     * Register the Capsule service.
     * Ref: http://stackoverflow.com/questions/17105829/using-eloquent-orm-from-laravel-4-outside-of-laravel.
     *
     * @param $container
     **/
    public function register(PimpleContainer $container)
    {
        $container['capsule.connection_defaults'] = [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => null,
            'username' => 'root',
            'password' => null,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => null,
            'logging' => false,
        ];

        $container['capsule.container'] = function () {
            return new Container();
        };

        $container['capsule.dispatcher'] = function () use ($container) {
            return new Dispatcher($container['capsule.container']);
        };

        if (class_exists('Illuminate\Cache\CacheManager')) {
            $container['capsule.cache_manager'] = function () use ($container) {
                return new CacheManager($container['capsule.container']);
            };
        }

        $container['capsule.eloquent'] = true;

        $container['capsule'] = function ($container) {
            $capsule = new Manager($container['capsule.container']);
            $capsule->setEventDispatcher($container['capsule.dispatcher']);

            if (isset($container['capsule.cache_manager']) && isset($container['capsule.cache'])) {
                $capsule->setCacheManager($container['capsule.cache_manager']);

                foreach ($container['capsule.cache'] as $key => $value) {
                    $container['capsule.container']->offsetGet('config')->offsetSet('cache.'.$key, $value);
                }
            }

            if (!isset($container['capsule.connections'])) {
                $container['capsule.connections'] = [
                    'default' => (isset($container['capsule.connection']) ? $container['capsule.connection'] : []),
                ];
            }

            foreach ($container['capsule.connections'] as $connection => $options) {
                $options = array_replace($container['capsule.connection_defaults'], $options);
                $logging = $options['logging'];
                unset($options['logging']);

                $capsule->addConnection($options, $connection);

                if ($logging) {
                    $capsule->getConnection($connection)->enableQueryLog();
                } else {
                    $capsule->getConnection($connection)->disableQueryLog();
                }
            }

            $capsule->bootEloquent();
            $capsule->setAsGlobal();

            $container['db'] = $container->factory(function ($c) {
                return Manager::connection();
            });

            return $capsule;
        };
    }
}
