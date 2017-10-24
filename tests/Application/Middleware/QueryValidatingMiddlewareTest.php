<?php declare(strict_types = 1);

namespace Tests\Mailbox\Application\Middleware;

use Mailbox\Application\Middleware\QueryValidatorMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

final class QueryValidatorMiddlewareTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItValidatesQuery() : void
    {
        $response = (new QueryValidatorMiddleware(__DIR__ . '/schema.json'))
            ->__invoke(
                new Request('GET', new Uri('http', 'localhost', null, '/', 'uid=1'), new Headers(), [], [], new RequestBody()),
                new Response(200),
                function (ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface {
                    $this->assertEquals(['uid' => '1'], $request->getQueryParams());

                    return $response;
                }
            );

        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testThatItReturnsErrors() : void
    {
        $response = (new QueryValidatorMiddleware(__DIR__ . '/schema.json'))
            ->__invoke(
            new Request('GET', new Uri('http', 'localhost'), new Headers(), [], [], new RequestBody()),
            new Response(200),
            function (ServerRequestInterface $request, ResponseInterface $response) : ResponseInterface {
                return $response;
            }
        );

        $this->assertEquals(400, $response->getStatusCode());
    }
}
