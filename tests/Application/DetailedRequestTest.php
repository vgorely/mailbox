<?php declare(strict_types = 1);

namespace Tests\Mailbox\Application;

use Mailbox\Application\Request\DetailedRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

final class DetailedRequestTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItReturnsArray() : void
    {
        $uri = $this->prophesize(UriInterface::class);
        $uri->__toString()->shouldBeCalled()->willReturn('/');

        $stream = $this->prophesize(StreamInterface::class);
        $stream->__toString()->shouldBeCalled()->willReturn('limit=100');

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getMethod()->shouldBeCalled()->willReturn('GET');
        $request->getUri()->shouldBeCalled()->willReturn($uri->reveal());
        $request->getQueryParams()->shouldBeCalled()->willReturn(['limit' => '100']);
        $request->getBody()->shouldBeCalled()->willReturn($stream->reveal());

        $this->assertEquals(
            [
                'method' => 'GET',
                'uri' => '/',
                'query' => ['limit' => '100'],
                'body' => 'limit=100',
            ],
            (new DetailedRequest($request->reveal()))->toArray()
        );
    }
}
