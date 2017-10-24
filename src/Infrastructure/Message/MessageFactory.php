<?php declare(strict_types = 1);

namespace Mailbox\Infrastructure\Message;

use Doctrine\DBAL\Connection;
use Mailbox\Domain\Message\MessageFactoryInterface;
use Mailbox\Domain\Message\MessageInterface;
use Mailbox\Infrustructure\Message\Message;

/**
 * @codeCoverageIgnore
 */
final class MessageFactory implements MessageFactoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function byUid(int $uid) : MessageInterface
    {
        return new Message($this->connection, $uid);
    }
}
