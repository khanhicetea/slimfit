<?php

namespace App\Lib;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Slim\Handlers\Error;

final class ErrorHandler extends Error
{
    protected $logger;

    public function __construct($displayErrorDetails = false, Logger $logger)
    {
        parent::__construct($displayErrorDetails);

        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, \Exception $exception)
    {
        // Log the message
        $this->logger->critical($exception->getMessage());

        return parent::__invoke($request, $response, $exception);
    }
}
