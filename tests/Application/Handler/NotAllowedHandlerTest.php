<?php declare(strict_types = 1);

namespace Tests\Mailbox\Application\Handler;

use Mailbox\Application\Handler\NotAllowedHandler;
use PHPUnit\Framework\TestCase;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

final class NotAllowedHandlerTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItReturnsResponse() : void
    {
        $response = (new NotAllowedHandler())
            ->__invoke(
                new Request('GET', new Uri('http', 'localhost'), new Headers(), [], [], new RequestBody()),
                new Response(),
                ['GET', 'POST']
            );

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(['application/json;charset=utf-8'], $response->getHeader('Content-Type'));
        $this->assertEquals(405, $response->getStatusCode());
        $this->assertArrayHasKey('message', json_decode((string) $response->getBody(), true));
    }
}
