<?php

namespace App\Http\Controller;

class Home extends Base
{
    protected function home()
    {
        return $this->res->withJson(['hello' => 'world']);
    }
}
