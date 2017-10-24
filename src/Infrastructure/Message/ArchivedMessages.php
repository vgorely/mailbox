<?php declare(strict_types = 1);

namespace Mailbox\Infrustructure\Message;

use Doctrine\DBAL\Connection;
use Mailbox\Domain\Message\MessagesInterface;

final class ArchivedMessages implements MessagesInterface
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
    public function total() : int
    {
        return (int) $this->connection->createQueryBuilder()
            ->select('COUNT(uid)')
            ->from('messages')
            ->where('time_archived IS NOT NULL')
            ->execute()
            ->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    public function toPaginatedArray(int $offset, int $limit) : array
    {
        return $this->connection->createQueryBuilder()
            ->select([
                'uid',
                'sender',
                'subject',
                'message',
                'time_sent',
                'time_read',
            ])
            ->from('messages')
            ->where('time_archived IS NOT NULL')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('time_sent')
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);
    }
}
