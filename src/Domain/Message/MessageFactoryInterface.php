<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message;

interface MessageFactoryInterface
{
    /**
     * @param int $uid
     *
     * @return MessageInterface
     */
    public function byUid(int $uid) : MessageInterface;
}
