<?php
namespace App\ServiceProvider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use App\Http\Kernel;
use App\CallableResolver;
use Slim\Handlers\Strategies\RequestResponseArgs;

class HttpKernel implements ServiceProviderInterface {
    private $route_path = 'Http/routes.php';
    private $namespace = '\\App\\Http\\Controller\\';

    public function register(Container $container) {
        if (!$container->has('kernel.route_path')) {
            $container['kernel.route_path'] = app_path($this->route_path);
        }

        if (!$container->has('kernel.namespace')) {
            $container['kernel.namespace'] = $this->namespace;
        }

        $container['kernel'] = function($container) {
            return new Kernel($container);
        };

        $container['foundHandler'] = function() {
            return new RequestResponseArgs();
        };

        $container['callableResolver'] = function ($container) {
            return new CallableResolver($container);
        };
    }
}
