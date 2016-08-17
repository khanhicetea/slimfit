<?php
namespace App\Http\Controller;

use App\Model\Admin;

class Home extends Base {
    public function hello($req, $res, $args) {
        $admin = Admin::find(1);
        return $this->view->render($res, 'hello.html', ['admin' => $admin]);
    }
}
