<?php declare(strict_types = 1);

namespace Mailbox\Application\Provider;

use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
final class LogProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(ContainerInterface $container) : void
    {
        $container[LoggerInterface::class] = function () {
            $streamHandler = new StreamHandler('/var/log/mailbox/app.log');
            $streamHandler->setFormatter(new LogstashFormatter('app', 'mailbox'));

            return new Logger('mailbox', [$streamHandler]);
        };
    }
}
