<?php declare(strict_types = 1);

namespace Mailbox\Application\Request;

use Psr\Http\Message\ServerRequestInterface;

final class DetailedRequest
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'method' => $this->request->getMethod(),
            'uri' => (string) $this->request->getUri(),
            'query' => $this->request->getQueryParams(),
            'body' => (string) $this->request->getBody(),
        ];
    }
}
