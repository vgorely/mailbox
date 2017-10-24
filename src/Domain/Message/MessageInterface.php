<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message;

use Mailbox\Domain\Message\Exception\MessageNotFoundException;

interface MessageInterface
{
    /**
     * @return void
     */
    public function archive() : void;

    /**
     * @return void
     */
    public function read() : void;

    /**
     * @throws MessageNotFoundException
     * @return array
     */
    public function toArray() : array;
}
