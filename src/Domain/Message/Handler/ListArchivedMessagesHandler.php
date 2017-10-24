<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ListArchivedMessagesCommand;
use Mailbox\Domain\Message\MessagesFactoryInterface;

final class ListArchivedMessagesHandler
{
    /**
     * @var MessagesFactoryInterface
     */
    private $messagesFactory;

    /**
     * @param MessagesFactoryInterface $messagesFactory
     */
    public function __construct(MessagesFactoryInterface $messagesFactory)
    {
        $this->messagesFactory = $messagesFactory;
    }

    /**
     * @param ListArchivedMessagesCommand $command
     *
     * @return array
     */
    public function handle(ListArchivedMessagesCommand $command) : array
    {
        $messages = $this->messagesFactory->archived();

        return [
            'messages' => $messages->toPaginatedArray($command->getOffset(), $command->getLimit()),
            'total' => $messages->total(),
        ];
    }
}
