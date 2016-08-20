<?php

namespace App\Http\Controller;

use Pimple\Container;

abstract class Base
{
    protected $container;
    protected $req;
    protected $res;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($key)
    {
        return $this->container->get($key);
    }

    public function __call($method, $args)
    {
        $this->req = array_shift($args);
        $this->res = array_shift($args);

        return call_user_func_array([$this, $method], $args);
    }
}
