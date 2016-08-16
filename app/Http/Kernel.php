<?php
namespace App\Http;

class Kernel {
    private $booted = false;

    public function boot() {
        if ($this->booted) {
            return false;
        }

        $this->booted = true;
        require __DIR__.'/routes.php';
    }
}
