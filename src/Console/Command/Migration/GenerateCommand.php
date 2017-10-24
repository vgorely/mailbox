<?php declare(strict_types = 1);

namespace Mailbox\Console\Command\Migration;

use Doctrine\DBAL\Migrations\Tools\Console\Command as DoctrineCommand;

/**
 * Overwrite the template according to the PHP7 standards
 */
class GenerateCommand extends DoctrineCommand\GenerateCommand
{
    /**
     * @var string
     */
    private $template =
        '<?php declare(strict_types = 1);

namespace <namespace>;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * @SuppressWarnings(PHPMD.ShortMethodName)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 *
 * @codeCoverageIgnore
 */
final class Version<version> extends AbstractMigration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema) : void
    {
        /**
         * Naming conventions:
         *  - Table name should be in plural and use an underscore as a word separator
         *
         *  - Column name which is a primary key should be named as `{table name in singular}_id`  
         *  - Column name should use an underscore as a word separator
         *  
         *  - Foreign key should be named as `fk_{table name}_{column name}__{foreign table name}_{foreign column name}`
         *  - Unique key should be named as `uniq_{table name}_{column name}`
         *
         *  - Index for a primary key should be named as `pk_{table name}`
         *  - Index for a foreign key should be named as `fk_{table name}_{column name}` 
         *  - Index for a column should be named as `idx_{table name}_{column name}`
         */<up>
    }

    /**
     * {@inheritdoc}
     */
    public function down(Schema $schema) : void
    {<down>
    }
}
';

    /**
     * @return string
     */
    protected function getTemplate() : string
    {
        return $this->template;
    }
}
