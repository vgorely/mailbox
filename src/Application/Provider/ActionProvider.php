<?php declare(strict_types = 1);

namespace Mailbox\Application\Provider;

use Mailbox\Application\Controller\Message;
use Mailbox\Application\Controller\StatusAction;
use Mailbox\Domain\Message\Handler\ArchiveMessageHandler;
use Mailbox\Domain\Message\Handler\ListArchivedMessagesHandler;
use Mailbox\Domain\Message\Handler\ListMessagesHandler;
use Mailbox\Domain\Message\Handler\ReadMessageHandler;
use Mailbox\Domain\Message\Handler\ShowMessageHandler;
use Mailbox\Domain\Message\MessageFactoryInterface;
use Mailbox\Domain\Message\MessagesFactoryInterface;
use Psr\Container\ContainerInterface;
use ZendDiagnostics\Runner\Runner;

/**
 * @codeCoverageIgnore
 */
final class ActionProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(ContainerInterface $container) : void
    {
        $this->registerMessageActions($container);

        $container[StatusAction::class] = function (ContainerInterface $container) {
            return new StatusAction(
                $container[Runner::class]
            );
        };
    }

    /**
     * @param ContainerInterface $container
     *
     * @return void
     */
    private function registerMessageActions(ContainerInterface $container) : void
    {
        $container[Message\ArchiveMessageAction::class] = function (ContainerInterface $container) {
            return new Message\ArchiveMessageAction(
                new ArchiveMessageHandler($container->get(MessageFactoryInterface::class))
            );
        };

        $container[Message\ListArchivedMessagesAction::class] = function (ContainerInterface $container) {
            return new Message\ListArchivedMessagesAction(
                new ListArchivedMessagesHandler($container->get(MessagesFactoryInterface::class))
            );
        };

        $container[Message\ListMessagesAction::class] = function (ContainerInterface $container) {
            return new Message\ListMessagesAction(
                new ListMessagesHandler($container->get(MessagesFactoryInterface::class))
            );
        };

        $container[Message\ReadMessageAction::class] = function (ContainerInterface $container) {
            return new Message\ReadMessageAction(
                new ReadMessageHandler($container->get(MessageFactoryInterface::class))
            );
        };

        $container[Message\ShowMessageAction::class] = function (ContainerInterface $container) {
            return new Message\ShowMessageAction(
                new ShowMessageHandler($container->get(MessageFactoryInterface::class))
            );
        };
    }
}
