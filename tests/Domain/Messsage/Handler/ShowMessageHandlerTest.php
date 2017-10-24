<?php declare(strict_types = 1);

namespace Tests\Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ShowMessageCommand;
use Mailbox\Domain\Message\Handler\ShowMessageHandler;
use Mailbox\Domain\Message\MessageFactoryInterface;
use Mailbox\Domain\Message\MessageInterface;
use PHPUnit\Framework\TestCase;

class ShowMessageHandlerTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItHandlesCommand() : void
    {
        $uid = 1;
        $messageArray = [];

        $message = $this->prophesize(MessageInterface::class);
        $message->toArray()->shouldBeCalled()->willReturn($messageArray);

        $messageFactory = $this->prophesize(MessageFactoryInterface::class);
        $messageFactory->byUid($uid)->shouldBeCalled()->willReturn($message->reveal());

        $handler = new ShowMessageHandler($messageFactory->reveal());

        $this->assertEquals($messageArray, $handler->handle(new ShowMessageCommand($uid)));
    }
}
