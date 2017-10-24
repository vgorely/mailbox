<?php declare(strict_types = 1);

namespace Mailbox\Application\Controller\Message;

use Mailbox\Application\Controller\ActionInterface;
use Mailbox\Domain\Message\Command\ListArchivedMessagesCommand;
use Mailbox\Domain\Message\Handler\ListArchivedMessagesHandler;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @codeCoverageIgnore
 */
final class ListArchivedMessagesAction implements ActionInterface
{
    /**
     * @var ListArchivedMessagesHandler
     */
    private $handler;

    /**
     * @param ListArchivedMessagesHandler $handler
     */
    public function __construct(ListArchivedMessagesHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, array $args) : Response
    {
        $command = new ListArchivedMessagesCommand(
            (int) $request->getParam('offset'),
            (int) $request->getParam('limit')
        );

        $data = $this->handler->handle($command);

        return $response->withJson($data, 200);
    }
}
