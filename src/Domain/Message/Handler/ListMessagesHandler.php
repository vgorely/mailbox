<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ListMessagesCommand;
use Mailbox\Domain\Message\MessagesFactoryInterface;

final class ListMessagesHandler
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
     * @param ListMessagesCommand $command
     *
     * @return array
     */
    public function handle(ListMessagesCommand $command) : array
    {
        $messages = $this->messagesFactory->all();

        return [
            'messages' => $messages->toPaginatedArray($command->getOffset(), $command->getLimit()),
            'total' => $messages->total(),
        ];
    }
}
