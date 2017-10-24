<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message\Command;

final class ReadMessageCommand
{
    /**
     * @var int
     */
    private $uid;

    /**
     * @param int $uid
     */
    public function __construct(int $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return int
     */
    public function getUid() : int
    {
        return $this->uid;
    }
}
