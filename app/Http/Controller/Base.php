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
        $this->req = $args[0];
        $this->res = $args[1];

        return $this->$method($args[2]);
    }
}
