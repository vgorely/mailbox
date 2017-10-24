<?php declare(strict_types = 1);

namespace Mailbox\Application\Handler;

use Slim\Http\Request;
use Slim\Http\Response;

final class NotAllowedHandler
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array $methods
     *
     * @return Response
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(Request $request, Response $response, array $methods) : Response
    {
        return $response
            ->withHeader('Allow', implode(', ', $methods))
            ->withJson(['message' => 'Method not allowed'], 405);
    }
}
