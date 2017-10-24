<?php declare(strict_types = 1);

use Mailbox\Application\Provider;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new App();

$container = $app->getContainer();

(new Provider\ActionProvider())->register($container);
(new Provider\DbProvider())->register($container);
(new Provider\HandlerProvider())->register($container);
(new Provider\LogProvider())->register($container);
(new Provider\MessageProvider())->register($container);
(new Provider\RunnerProvider())->register($container);

return $app;
