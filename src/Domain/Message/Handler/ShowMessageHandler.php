<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ShowMessageCommand;
use Mailbox\Domain\Message\MessageFactoryInterface;

final class ShowMessageHandler
{
    /**
     * @var MessageFactoryInterface
     */
    private $messageFactory;

    /**
     * @param MessageFactoryInterface $messageFactory
     */
    public function __construct(MessageFactoryInterface $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param ShowMessageCommand $command
     *
     * @return array
     */
    public function handle(ShowMessageCommand $command) : array
    {
        $message = $this->messageFactory->byUid($command->getUid());

        return $message->toArray();
    }
}
