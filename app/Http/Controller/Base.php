<?php
namespace App\Http\Controller;

use Pimple\Container;

abstract class Base {
    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function __get($key) {
        return $this->container->get($key);
    }
}
