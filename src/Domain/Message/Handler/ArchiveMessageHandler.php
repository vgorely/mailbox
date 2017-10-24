<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ArchiveMessageCommand;
use Mailbox\Domain\Message\MessageFactoryInterface;

final class ArchiveMessageHandler
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
     * @param ArchiveMessageCommand $command
     *
     * @return void
     */
    public function handle(ArchiveMessageCommand $command) : void
    {
        $message = $this->messageFactory->byUid($command->getUid());

        $message->archive();
    }
}
