<?php declare(strict_types = 1);

namespace Mailbox\Application\Provider;

use Psr\Container\ContainerInterface;
use ZendDiagnostics\Check\PDOCheck;
use ZendDiagnostics\Runner\Runner;

/**
 * @codeCoverageIgnore
 */
final class RunnerProvider implements ProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(ContainerInterface $container) : void
    {
        $container[Runner::class] = function (ContainerInterface $container) {
            $runner = new Runner();

            $dsn = sprintf(
                '%s:dbname=%s;host=%s;',
                substr($container->get('db.driver'), 4),
                substr(parse_url($container->get('db.dsn'), PHP_URL_PATH), 1),
                parse_url($container->get('db.dsn'), PHP_URL_HOST)
            );
            $username = parse_url($container->get('db.dsn'), PHP_URL_USER);
            $password = parse_url($container->get('db.dsn'), PHP_URL_PASS);

            $runner->addChecks([
                'pgsql' => new PDOCheck($dsn, $username, $password),
            ]);

            return $runner;
        };
    }
}
