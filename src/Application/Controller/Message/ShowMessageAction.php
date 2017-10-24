<?php declare(strict_types = 1);

namespace Mailbox\Application\Controller\Message;

use Mailbox\Application\Controller\ActionInterface;
use Mailbox\Domain\Message\Command\ShowMessageCommand;
use Mailbox\Domain\Message\Exception\MessageNotFoundException;
use Mailbox\Domain\Message\Handler\ShowMessageHandler;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @codeCoverageIgnore
 */
final class ShowMessageAction implements ActionInterface
{
    /**
     * @var ShowMessageHandler
     */
    private $handler;

    /**
     * @param ShowMessageHandler $handler
     */
    public function __construct(ShowMessageHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, array $args) : Response
    {
        try {
            $command = new ShowMessageCommand((int) $args['uid'] ?? 0);

            $data = $this->handler->handle($command);

            return $response->withJson($data, 200);
        } catch (MessageNotFoundException $exception) {
            return $response->withStatus(404);
        }
    }
}
