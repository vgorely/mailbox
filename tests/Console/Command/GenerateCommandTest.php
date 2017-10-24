<?php declare(strict_types = 1);

namespace Tests\HelloFresh\ShippingLabel\Console\Command;

use Mailbox\Console\Command\Migration\GenerateCommand;
use PHPUnit\Framework\TestCase;

class GenerateCommandTest extends TestCase
{
    public function testThatItReturnsOverwrittenTemplate() : void
    {
        $generateCommand = new class() extends GenerateCommand {
            public function getTemplatePublic()
            {
                return $this->getTemplate();
            }
        };

        $template = $generateCommand->getTemplatePublic();

        $this->assertInternalType('string', $template);
        $this->assertStringStartsWith('<?php declare(strict_types = 1);', $template);
        $this->assertContains('public function up(Schema $schema) : void', $template);
        $this->assertContains('public function down(Schema $schema) : void', $template);
    }
}
