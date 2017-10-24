<?php declare(strict_types = 1);

namespace Mailbox\Application\Controller\Message;

use Mailbox\Application\Controller\ActionInterface;
use Mailbox\Domain\Message\Command\ArchiveMessageCommand;
use Mailbox\Domain\Message\Handler\ArchiveMessageHandler;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @codeCoverageIgnore
 */
final class ArchiveMessageAction implements ActionInterface
{
    /**
     * @var ArchiveMessageHandler
     */
    private $handler;

    /**
     * @param ArchiveMessageHandler $handler
     */
    public function __construct(ArchiveMessageHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, array $args) : Response
    {
        $command = new ArchiveMessageCommand((int) $args['uid'] ?? 0);

        $this->handler->handle($command);

        return $response->withStatus(200);
    }
}
