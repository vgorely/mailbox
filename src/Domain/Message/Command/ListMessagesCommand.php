<?php declare(strict_types = 1);

namespace Mailbox\Domain\Message\Command;

final class ListMessagesCommand
{
    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $limit;

    /**
     * @param int $offset
     * @param int $limit
     */
    public function __construct(int $offset, int $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset() : int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit() : int
    {
        return $this->limit;
    }
}
