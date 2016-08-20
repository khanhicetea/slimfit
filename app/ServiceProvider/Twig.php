<?php

namespace App\ServiceProvider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Slim\Views\TwigExtension;
use Slim\Views\Twig as TwigView;

class Twig implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['view.slim_ext'] = function ($c) {
            $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');

            return new TwigExtension($c['router'], $basePath);
        };

        $container['view'] = function ($c) {
            $opts = [];

            if (isset($c['view.cache']) && $c['view.cache'] === true) {
                $opts['cache'] = storage_path('cache');
            }

            $view = new TwigView(resources_path('views'), $opts);
            $view->addExtension($c['view.slim_ext']);

            return $view;
        };
    }
}
