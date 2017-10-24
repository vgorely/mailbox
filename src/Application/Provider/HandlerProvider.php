<?php declare(strict_types = 1);

namespace Mailbox\Application\Provider;

use Mailbox\Application\Handler\NotAllowedHandler;
use Mailbox\Application\Handler\NotFoundHandler;
use Mailbox\Application\Handler\ThrowableHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
final class HandlerProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(ContainerInterface $container) : void
    {
        $container['notFoundHandler'] = function () {
            return new NotFoundHandler();
        };

        $container['notAllowedHandler'] = function () {
            return new NotAllowedHandler();
        };

        $container['phpErrorHandler'] = function (ContainerInterface $container) {
            return new ThrowableHandler(
                $container->get(LoggerInterface::class),
                $container->get('is_debug')
            );
        };

        $container['errorHandler'] = function (ContainerInterface $container) {
            return new ThrowableHandler(
                $container->get(LoggerInterface::class),
                $container->get('is_debug')
            );
        };
    }
}
