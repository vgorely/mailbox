<?php declare(strict_types = 1);

namespace Mailbox\Application\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use ZendDiagnostics\Runner\Runner;

/**
 * @codeCoverageIgnore
 */
final class StatusAction implements ActionInterface
{
    /**
     * @var Runner
     */
    private $runner;

    /**
     * @param Runner $runner
     */
    public function __construct(Runner $runner)
    {
        $this->runner = $runner;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, array $args) : Response
    {
        return $response->withJson(
            [
                'pgsql' => (bool) $this->runner->run('pgsql')->getSuccessCount(),
            ],
            200
        );
    }
}
