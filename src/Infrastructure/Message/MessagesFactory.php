<?php declare(strict_types = 1);

namespace Mailbox\Infrastructure\Message;

use Doctrine\DBAL\Connection;
use Mailbox\Domain\Message\MessagesFactoryInterface;
use Mailbox\Domain\Message\MessagesInterface;
use Mailbox\Infrustructure\Message\ArchivedMessages;
use Mailbox\Infrustructure\Message\Messages;

/**
 * @codeCoverageIgnore
 */
final class MessagesFactory implements MessagesFactoryInterface
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
    public function all() : MessagesInterface
    {
        return new Messages($this->connection);
    }

    /**
     * {@inheritdoc}
     */
    public function archived() : MessagesInterface
    {
        return new ArchivedMessages($this->connection);
    }
}
