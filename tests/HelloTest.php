<?php
namespace App\Tests;

use PHPUnit_Framework_TestCase;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

class HelloTest extends PHPUnit_Framework_TestCase {
    public function testHomeRoute() {
        $env = Environment::mock([
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => '/',
            'REQUEST_METHOD' => 'GET',
        ]);
        $request = Request::createFromEnvironment($env);
        $response = app()->process($request, new Response());

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testHelloRoute() {
        $env = Environment::mock([
            'SCRIPT_NAME' => '/index.php',
            'REQUEST_URI' => '/hello/SlimFit',
            'REQUEST_METHOD' => 'GET',
        ]);
        $request = Request::createFromEnvironment($env);
        $response = app()->process($request, new Response());

        $this->assertEquals(200, $response->getStatusCode());
    }
}
