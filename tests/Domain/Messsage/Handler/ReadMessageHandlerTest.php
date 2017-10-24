<?php declare(strict_types = 1);

namespace Tests\Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ReadMessageCommand;
use Mailbox\Domain\Message\Handler\ReadMessageHandler;
use Mailbox\Domain\Message\MessageFactoryInterface;
use Mailbox\Domain\Message\MessageInterface;
use PHPUnit\Framework\TestCase;

class ReadMessageHandlerTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItHandlesCommand() : void
    {
        $uid = 1;

        $message = $this->prophesize(MessageInterface::class);
        $message->read()->shouldBeCalled();

        $messageFactory = $this->prophesize(MessageFactoryInterface::class);
        $messageFactory->byUid($uid)->shouldBeCalled()->willReturn($message->reveal());

        $handler = new ReadMessageHandler($messageFactory->reveal());
        $handler->handle(new ReadMessageCommand($uid));
    }
}
