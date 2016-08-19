<?php

use PHPPM\Bootstraps\BootstrapInterface;

class PpmBootstrap implements BootstrapInterface {
    private $appenv;
    private $debug;

    public function __construct($appenv, $debug) {
        $this->appenv = $appenv;
        $this->debug = $debug;
    }

    public function getApplication() {
        return (require __DIR__.'/bootstrap/app.php');
    }

    public function getStaticDirectory() {
        return realpath(__DIR__.'/public');
    }
}
