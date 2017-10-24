<?php declare(strict_types = 1);

namespace Mailbox\Application\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

interface ActionInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args) : Response;
}
