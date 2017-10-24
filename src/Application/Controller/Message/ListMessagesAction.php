<?php declare(strict_types = 1);

namespace Mailbox\Application\Controller\Message;

use Mailbox\Application\Controller\ActionInterface;
use Mailbox\Domain\Message\Command\ListMessagesCommand;
use Mailbox\Domain\Message\Handler\ListMessagesHandler;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * @codeCoverageIgnore
 */
final class ListMessagesAction implements ActionInterface
{
    /**
     * @var ListMessagesHandler
     */
    private $handler;

    /**
     * @param ListMessagesHandler $handler
     */
    public function __construct(ListMessagesHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, array $args) : Response
    {
        $command = new ListMessagesCommand(
            (int) $request->getParam('offset'),
            (int) $request->getParam('limit')
        );

        $data = $this->handler->handle($command);

        return $response->withJson($data, 200);
    }
}
