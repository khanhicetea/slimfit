<?php

namespace App\Http;

use PHPPM\Bridges\BridgeInterface;
use React\Http\Request;
use PHPPM\React\HttpResponse;
use Slim\Http\Request as SlimRequest;
use Slim\Http\Response as SlimResponse;
use Slim\Http\Uri;
use Slim\Http\Headers;
use Slim\Http\Body;

class PpmBridge implements BridgeInterface
{
    private $bootstrap;
    private $app;

    public function bootstrap($appBootstrap, $appenv, $debug)
    {
        $this->bootstrap = new $appBootstrap($appenv, $debug);
        $this->app = $this->bootstrap->getApplication();
        $this->app->getContainer()->get('kernel')->boot();
    }

    public function getStaticDirectory()
    {
        return $this->bootstrap->getStaticDirectory();
    }

    public function onRequest(Request $request, HttpResponse $response)
    {
        $slim_request = static::mapRequest($request);
        $slim_response = $this->app->process($slim_request, new SlimResponse());
        static::mapResponse($slim_response, $response);
    }

    public static function mapRequest($react_request)
    {
        $headers = new Headers();
        foreach ($react_request->getHeaders() as $key => $value) {
            $headers->add($key, $value);
        }
        $body = fopen('php://temp', 'w+');
        fwrite($body, $react_request->getBody());
        fseek($body, 0);

        $request = new SlimRequest(
            $react_request->getMethod(),
            Uri::createFromString($react_request->getUrl()),
            $headers,
            [],
            $_SERVER,
            new Body($body),
            []
        );

        return $request;
    }

    public static function mapResponse($response, $react_response)
    {
        $react_response->writeHead($response->getStatusCode(), $response->getHeaders());
        $react_response->end((string) $response->getBody());
    }
}
