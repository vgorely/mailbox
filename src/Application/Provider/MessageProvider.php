<?php declare(strict_types = 1);

namespace Mailbox\Application\Provider;

use Doctrine\DBAL\Connection;
use Mailbox\Domain\Message\MessageFactoryInterface;
use Mailbox\Domain\Message\MessagesFactoryInterface;
use Mailbox\Infrastructure\Message\MessageFactory;
use Mailbox\Infrastructure\Message\MessagesFactory;
use Psr\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
final class MessageProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(ContainerInterface $container) : void
    {
        $container[MessageFactoryInterface::class] = function (ContainerInterface $container) {
            return new MessageFactory($container->get(Connection::class));
        };

        $container[MessagesFactoryInterface::class] = function (ContainerInterface $container) {
            return new MessagesFactory($container->get(Connection::class));
        };
    }
}
