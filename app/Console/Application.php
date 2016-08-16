<?php
namespace App\Console;

use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication {
    private $container;

    public function setContainer(Container $container) {
        $this->container = $container;
    }

    public function getContainer() {
        return $this->container;
    }
}
