<?php declare(strict_types = 1);

namespace Tests\Mailbox\Application\Handler;

use Mailbox\Application\Handler\ThrowableHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

final class ThrowableHandlerTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItLogsThrowableAndReturnsResponse() : void
    {
        $request = new Request('GET', new Uri('http', 'localhost'), new Headers(), [], [], new RequestBody());

        $logger = $this->prophesize(LoggerInterface::class);
        $logger->error(Argument::cetera())->shouldBeCalled();

        $response = (new ThrowableHandler($logger->reveal(), true))->__invoke($request, new Response(), new \Exception());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(['application/json;charset=utf-8'], $response->getHeader('Content-Type'));
        $this->assertEquals(500, $response->getStatusCode());
        $this->assertArrayHasKey('message', json_decode((string) $response->getBody(), true));
    }

    /**
     * @return void
     */
    public function testThatItReturnsThrowableArrayIfDebugIsEnabled() : void
    {
        $request = new Request('GET', new Uri('http', 'localhost'), new Headers(), [], [], new RequestBody());

        $logger = $this->prophesize(LoggerInterface::class);

        $response = (new ThrowableHandler($logger->reveal(), true))->__invoke($request, new Response(), new \Exception());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayHasKey('throwable', json_decode((string) $response->getBody(), true));
    }

    /**
     * @return void
     */
    public function testThatItDoesNotReturnThrowableArrayIfDebugIsDisabled() : void
    {
        $request = new Request('GET', new Uri('http', 'localhost'), new Headers(), [], [], new RequestBody());

        $logger = $this->prophesize(LoggerInterface::class);

        $response = (new ThrowableHandler($logger->reveal(), false))->__invoke($request, new Response(), new \Exception());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertArrayNotHasKey('throwable', json_decode((string) $response->getBody(), true));
    }
}
