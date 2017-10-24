<?php declare(strict_types = 1);

namespace Mailbox\Application\Provider;

use Psr\Container\ContainerInterface;

interface ProviderInterface
{
    /**
     * @param ContainerInterface $container
     *
     * @return void
     */
    public function register(ContainerInterface $container) : void;
}
