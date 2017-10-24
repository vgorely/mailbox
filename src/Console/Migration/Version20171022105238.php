<?php declare(strict_types = 1);

namespace Mailbox\Console\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * @SuppressWarnings(PHPMD.ShortMethodName)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 *
 * @codeCoverageIgnore
 */
final class Version20171022105238 extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema) : void
    {
        $messagesTable = $schema->createTable('messages');

        $messagesTable->addColumn('uid', Type::INTEGER, ['autoincrement' => true, 'notnull' => true, 'unsigned' => true]);
        $messagesTable->addColumn('sender', Type::STRING, ['notnull' => true]);
        $messagesTable->addColumn('subject', Type::TEXT, ['notnull' => true]);
        $messagesTable->addColumn('message', Type::TEXT, ['notnull' => true]);
        $messagesTable->addColumn('time_sent', Type::INTEGER, ['notnull' => true, 'unsigned' => true]);
        $messagesTable->addColumn('time_read', Type::INTEGER, ['notnull' => false, 'unsigned' => true]);
        $messagesTable->addColumn('time_archived', Type::INTEGER, ['notnull' => false, 'unsigned' => true]);

        $messagesTable->setPrimaryKey(['uid']);
    }

    /**
     * {@inheritdoc}
     */
    public function postUp(Schema $schema)
    {
        $this->connection->query('ALTER INDEX messages_pkey RENAME TO pk_messages');
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema) : void
    {
        $schema->dropTable('messages');
    }
}
