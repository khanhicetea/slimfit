<?php
namespace App;

use Slim\App as SlimApp;

class SlimFit extends SlimApp {
    private static $instance = null;

    public static function init(array $opts = []) {
        if (static::$instance == null) {
            static::$instance = new static($opts);
        }

        return static::$instance;
    }

    public static function getKey($key = null) {
        return $key ? static::$instance[$key] : static::$instance;
    }

    public function register(ServiceProviderInterface $service) {
        $service->register($this);
    }
}
