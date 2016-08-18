<?php
namespace App\Http\Controller;

use App\Model\Admin;

class Home extends Base {
    protected function home() {
        return $this->redirect('hello', ['name' => 'SlimFit']);
    }

    protected function hello($name) {
        return $this->render('hello.html', ['name' => $name]);
    }
}
