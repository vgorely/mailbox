<?php declare(strict_types = 1);

use Slim\App;

/** @var App $app */

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../app/app.php';

require __DIR__ . '/../app/config.php';

require __DIR__ . '/../app/routes.php';

$app->run();
