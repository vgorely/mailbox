<?php declare(strict_types = 1);

namespace Mailbox\Application\Handler;

use Mailbox\Application\Request\DetailedRequest;
use Mailbox\Domain\Throwable\DetailedThrowable;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class ThrowableHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var bool
     */
    private $isDebug;

    /**
     * @param LoggerInterface $logger
     * @param bool $isDebug
     */
    public function __construct(LoggerInterface $logger, bool $isDebug)
    {
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param \Throwable $throwable
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, \Throwable $throwable) : Response
    {
        $this->log($request, $throwable);

        $data = ['message' => 'Internal server exception'];
        if ($this->isDebug) {
            $data['throwable'] = (new DetailedThrowable($throwable))->toArray();
        }

        return $response->withJson($data, 500);
    }

    /**
     * @param Request $request
     * @param \Throwable $throwable
     *
     * @return void
     */
    private function log(Request $request, \Throwable $throwable) : void
    {
        $this->logger->error(
            $throwable->getMessage(),
            [
                'request' => (new DetailedRequest($request))->toArray(),
                'throwable' => (new DetailedThrowable($throwable))->toArray(),
            ]
        );
    }
}
