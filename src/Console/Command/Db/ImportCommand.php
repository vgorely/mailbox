<?php declare(strict_types = 1);

namespace Mailbox\Console\Command\Db;

use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure() : void
    {
        parent::configure();

        $this->setName('db:import')->setDescription('Import file to database.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $file = __DIR__ . '/../../../../data/db.json';
        if (!file_exists($file)) {
            $output->writeln(sprintf('File not found. Path: %s', $file));

            return;
        }

        $data = json_decode(file_get_contents($file), true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            $output->writeln(sprintf('File could not be parsed'));

            return;
        }

        $messages = $data['messages'] ?? [];
        if (!$messages) {
            $output->writeln(sprintf('Messages not found'));

            return;
        }

        $connection = $this->getMigrationConfiguration($input, $output)->getConnection();

        $connection->transactional(function () use ($connection, $messages) : void {
            foreach ($messages as $message) {
                $connection->createQueryBuilder()
                    ->insert('messages')
                    ->values([
                        'uid' => ':uid',
                        'sender' => ':sender',
                        'subject' => ':subject',
                        'message' => ':message',
                        'time_sent' => ':time_sent',
                    ])
                    ->setParameters(
                        [
                            'uid' => $message['uid'],
                            'sender' => $message['subject'],
                            'subject' => $message['subject'],
                            'message' => $message['message'],
                            'time_sent' => $message['time_sent'],
                        ],
                        [
                            'uid' => Type::INTEGER,
                            'time_sent' => Type::INTEGER,
                        ]
                    )
                    ->execute();
            }

            $connection->exec("SELECT setval('messages_uid_seq', (SELECT max(uid) FROM messages))");
        });
    }
}
