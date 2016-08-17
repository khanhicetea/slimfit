<?php
namespace App\Http;

use Psr7Middlewares\Middleware;
use App\Http\Middleware\LanguageNegotiator;

class Kernel {
    protected $container;
    protected $booted = false;
    protected $route_path;

    public function __construct($container) {
        $this->container = $container;
        $this->route_path = $container['kernel.route_path'];
    }

    public function getAppMiddlewares() {
        return [
            Middleware::responseTime(),
        ];
    }

    public function getRouteMiddlewares() {
        return [];
    }

    public function boot() {
        if ($this->booted) {
            return false;
        }

        $this->booted = true;
        $this->addMiddlewares();
        $this->loadRoute();
    }

    private function addMiddlewares() {
        $app = app();
        $app_middlewares = $this->getAppMiddlewares();
        $route_middlewares = $this->getRouteMiddlewares();

        foreach ($app_middlewares as $middleware) {
            $app->add($middleware);
        }

        foreach ($route_middlewares as $name => $middleware) {
            $this->container['mw_'.$name] = function($container) use ($middleware) {
                return $middleware;
            };
        }
    }

    private function loadRoute() {
        require $this->route_path;
    }
}
