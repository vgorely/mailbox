<?php declare(strict_types = 1);

namespace Mailbox\Application\Controller\Message;

use Mailbox\Application\Controller\ActionInterface;
use Mailbox\Domain\Message\Command\ReadMessageCommand;
use Mailbox\Domain\Message\Handler\ReadMessageHandler;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @codeCoverageIgnore
 */
final class ReadMessageAction implements ActionInterface
{
    /**
     * @var ReadMessageHandler
     */
    private $handler;

    /**
     * @param ReadMessageHandler $handler
     */
    public function __construct(ReadMessageHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, array $args) : Response
    {
        $command = new ReadMessageCommand((int) $args['uid'] ?? 0);

        $this->handler->handle($command);

        return $response->withStatus(200);
    }
}
