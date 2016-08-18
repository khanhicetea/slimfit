<?php
namespace App\Http\Controller;

use Pimple\Container;

abstract class Base {
    protected $container;
    protected $req;
    protected $res;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    protected function render($template, array $data = []) {
        return $this->view->render($this->res, $template, $data);
    }

    protected function redirect($named_route, array $params = []) {
        $url = $this->router->pathFor($named_route, $params);

        return $this->res->withStatus(302)->withHeader('Location', $url);
    }

    public function __get($key) {
        return $this->container->get($key);
    }

    public function __call($method, $args) {
        $this->req = array_shift($args);
        $this->res = array_shift($args);

        return call_user_func_array([$this, $method], $args);
    }
}
