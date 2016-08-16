<?php
namespace App\ServiceProvider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use App\Http\Kernel;

class HttpKernel implements ServiceProviderInterface {
    public function register(Container $container) {
        $container['kernel'] = function() {
            $kernel = new Kernel();

            return $kernel;
        };
    }
}
