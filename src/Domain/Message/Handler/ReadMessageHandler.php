<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ReadMessageCommand;
use Mailbox\Domain\Message\MessageFactoryInterface;

final class ReadMessageHandler
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
     * @param ReadMessageCommand $command
     *
     * @return void
     */
    public function handle(ReadMessageCommand $command) : void
    {
        $message = $this->messageFactory->byUid($command->getUid());

        $message->read();
    }
}
