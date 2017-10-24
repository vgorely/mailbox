<?php declare(strict_types = 1);

namespace Tests\Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ArchiveMessageCommand;
use Mailbox\Domain\Message\Handler\ArchiveMessageHandler;
use Mailbox\Domain\Message\MessageFactoryInterface;
use Mailbox\Domain\Message\MessageInterface;
use PHPUnit\Framework\TestCase;

class ArchiveMessageHandlerTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItHandlesCommand() : void
    {
        $uid = 1;

        $message = $this->prophesize(MessageInterface::class);
        $message->archive()->shouldBeCalled();

        $messageFactory = $this->prophesize(MessageFactoryInterface::class);
        $messageFactory->byUid($uid)->shouldBeCalled()->willReturn($message->reveal());

        $handler = new ArchiveMessageHandler($messageFactory->reveal());
        $handler->handle(new ArchiveMessageCommand($uid));
    }
}
