<?php declare(strict_types = 1);

namespace Tests\Mailbox\Domain\Message\Handler;

use Mailbox\Domain\Message\Command\ListMessagesCommand;
use Mailbox\Domain\Message\Handler\ListMessagesHandler;
use Mailbox\Domain\Message\MessagesFactoryInterface;
use Mailbox\Domain\Message\MessagesInterface;
use PHPUnit\Framework\TestCase;

class ListMessagesHandlerTest extends TestCase
{
    /**
     * @return void
     */
    public function testThatItHandlesCommand() : void
    {
        $offset = 0;
        $limit = 1;

        $messagesArray = [];
        $total = 1;

        $messages = $this->prophesize(MessagesInterface::class);
        $messages->toPaginatedArray($offset, $limit)->shouldBeCalled()->willReturn($messagesArray);
        $messages->total()->shouldBeCalled()->willReturn($total);

        $messagesFactory = $this->prophesize(MessagesFactoryInterface::class);
        $messagesFactory->all()->shouldBeCalled()->willReturn($messages->reveal());

        $handler = new ListMessagesHandler($messagesFactory->reveal());

        $this->assertEquals(
            [
                'messages' => $messagesArray,
                'total' => $total,
            ],
            $handler->handle(new ListMessagesCommand($offset, $limit))
        );
    }
}
