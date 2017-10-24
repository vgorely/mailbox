<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message;

interface MessagesInterface
{
    /**
     * @return int
     */
    public function total() : int;

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function toPaginatedArray(int $offset, int $limit) : array;
}
