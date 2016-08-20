<?php

namespace App;

use Slim\App as SlimApp;
use Pimple\ServiceProviderInterface;

class SlimFit extends SlimApp
{
    private static $instance = null;

    public static function init(array $opts = [])
    {
        if (static::$instance == null) {
            static::$instance = new static($opts);
            static::$instance->loadConfig();
        }

        return static::$instance;
    }

    public static function getInstance()
    {
        return static::$instance;
    }

    public static function getKey($key = null)
    {
        $instance = static::$instance;

        return $key ? $instance->getContainer()->get($key) : $instance->getContainer();
    }

    public function loadConfig()
    {
        $container = $this->getContainer();
        foreach (glob(config_path().'/*.php') as $file) {
            $config = is_readable($file) ? (require $file) : [];
            $config_name = substr(strtolower(basename($file)), 0, -4);
            $container['config.'.$config_name] = $config;
        }
    }

    public function register(ServiceProviderInterface $service, array $opts = [])
    {
        $this->getContainer()->register($service, $opts);
    }
}
