<?php declare(strict_types = 1);

namespace Mailbox\Application\Provider;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
final class DbProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(ContainerInterface $container) : void
    {
        $container[Connection::class] = function (ContainerInterface $container) {
            return DriverManager::getConnection([
                'driver' => $container->get('db.driver'),
                'url' => $container->get('db.dsn'),
            ]);
        };
    }
}
