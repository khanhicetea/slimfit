<?php
namespace App\Http\Controller;

use App\Model\Admin;

class Home extends Base {
    protected function home($args) {
        return $this->redirect('hello', ['name' => 'SlimFit']);
    }

    protected function hello($args) {
        return $this->render('hello.html', ['name' => $args['name']]);
    }
}
