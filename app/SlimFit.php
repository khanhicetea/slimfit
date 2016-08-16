<?php
namespace App;

use Slim\App as SlimApp;
use Pimple\ServiceProviderInterface;

class SlimFit extends SlimApp {
    private static $instance = null;

    public static function init(array $opts = []) {
        if (static::$instance == null) {
            static::$instance = new static($opts);
        }

        return static::$instance;
    }

    public static function getInstance() {
        return static::$instance;
    }

    public static function getKey($key = null) {
        $instance = static::$instance;
        return $key ? $instance->getContainer()->get($key) : $instance->getContainer();
    }

    public function register(ServiceProviderInterface $service) {
        $service->register($this->getContainer());
    }
}
