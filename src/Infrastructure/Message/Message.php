<?php declare(strict_types = 1);

namespace Mailbox\Infrustructure\Message;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Mailbox\Domain\Message\Exception\MessageNotFoundException;
use Mailbox\Domain\Message\MessageInterface;

final class Message implements MessageInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var int
     */
    private $uid;

    /**
     * @param Connection $connection
     * @param int $uid
     */
    public function __construct(Connection $connection, int $uid)
    {
        $this->connection = $connection;
        $this->uid = $uid;
    }

    /**
     * {@inheritdoc}
     */
    public function archive() : void
    {
        $this->connection->createQueryBuilder()
            ->update('messages')
            ->set('time_archived', ':timeArchived')
            ->where('uid = :uid')
            ->setParameters(
                [
                    'timeArchived' => (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format('U'),
                    'uid' => $this->uid,
                ],
                [
                    'timeArchived' => Type::INTEGER,
                ]
            )
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function read() : void
    {
        $this->connection->createQueryBuilder()
            ->update('messages')
            ->set('time_read', ':timeRead')
            ->where('uid = :uid')
            ->setParameters(
                [
                    'timeRead' => (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format('U'),
                    'uid' => $this->uid,
                ],
                [
                    'timeRead' => Type::INTEGER,
                ]
            )
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        $message = $this->connection->createQueryBuilder()
            ->select([
                'uid',
                'sender',
                'subject',
                'message',
                'time_sent',
                'time_read',
                'time_archived',
            ])
            ->from('messages')
            ->where('uid = :uid')
            ->setParameter('uid', $this->uid, Type::INTEGER)
            ->execute()
            ->fetch(\PDO::FETCH_ASSOC);

        if (!$message) {
            throw new MessageNotFoundException(sprintf('Message not found. UID = %s', $this->uid));
        }

        return $message;
    }
}
