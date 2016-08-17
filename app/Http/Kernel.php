<?php
namespace App\Http;

use Psr7Middlewares\Middleware;
use Zend\Diactoros\Stream;

class Kernel {
    protected $container;
    protected $booted = false;
    protected $route_path;
    protected $app_middlewares;
    protected $route_middlewares;

    public function __construct($container) {
        $this->container = $container;
        $this->route_path = $container['kernel.route_path'];
        
        Middleware::setStreamFactory(function ($file, $mode) {
            return new Stream($file, $mode);
        });

        $this->defaultAppMiddlewares();
        $this->defaultRouteMiddlewares();
    }
    
    public function defaultAppMiddlewares() {
        $this->app_middlewares = [
            Middleware::responseTime(),
        ];
    }

    public function defaultRouteMiddlewares() {
        $this->route_middlewares = [];
    }

    public function setRouteMiddleware($key, $middleware) {
        $this->route_middlewares[$key] = $middleware;
    }

    public function appendAppMiddleware($middleware) {
        $this->app_middlewares[] = $middleware;
    }

    public function prependAppMiddleware($middleware) {
        array_unshift($this->app_middlewares, $middleware);
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

        foreach ($this->app_middlewares as $middleware) {
            $app->add($middleware);
        }

        foreach ($this->route_middlewares as $name => $middleware) {
            $this->container['mw_'.$name] = function($container) use ($middleware) {
                return $middleware;
            };
        }
    }

    private function loadRoute() {
        require $this->route_path;
    }
}
