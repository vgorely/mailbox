<?php declare(strict_types = 1);

namespace Mailbox\Application\Middleware;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class QueryValidatorMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $schema;

    /**
     * @param string $schema
     */
    public function __construct(string $schema)
    {
        $this->schema = $schema;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $next) : ResponseInterface
    {
        $query = $request->getQueryParams();

        $schema = (object) ['$ref' => sprintf('file://%s', realpath($this->schema))];

        $validator = new Validator();
        $validator->validate($query, $schema, Constraint::CHECK_MODE_TYPE_CAST);

        if (!$validator->isValid()) {
            return $response->withJson(
                [
                    'errors' => $validator->getErrors(),
                    'request' => ['query' => $query],
                ],
                400
            );
        }

        return $next($request, $response);
    }
}
