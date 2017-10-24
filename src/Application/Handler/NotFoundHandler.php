<?php declare(strict_types = 1);

namespace Mailbox\Application\Handler;

use Slim\Http\Request;
use Slim\Http\Response;

final class NotFoundHandler
{
    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(Request $request, Response $response) : Response
    {
        return $response->withJson(['message' => 'Not found'], 404);
    }
}
