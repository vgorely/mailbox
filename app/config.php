<?php declare(strict_types = 1);

use Slim\App;

/** @var App $app */

$container = $app->getContainer();

$container['is_debug'] = filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN);

$container['db.driver'] = 'pdo_pgsql';
$container['db.dsn'] = getenv('DB_DSN');
