<?php
namespace App\Http\Controller;

use App\Model\Admin;

class Home extends Base {
    protected function home() {
        return $this->res->withJson(['hello' => 'world']);
    }
}
