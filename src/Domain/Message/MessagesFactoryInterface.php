<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message;

interface MessagesFactoryInterface
{
    /**
     * @return MessagesInterface
     */
    public function all() : MessagesInterface;

    /**
     * @return MessagesInterface
     */
    public function archived() : MessagesInterface;
}
