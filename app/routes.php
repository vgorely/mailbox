<?php declare(strict_types = 1);

use Mailbox\Application\Controller\Message;
use Mailbox\Application\Controller\StatusAction;
use Mailbox\Application\Middleware\QueryValidatorMiddleware;
use Slim\App;

/** @var App $app */

$app->get('/status', StatusAction::class);

$app->get('/messages', Message\ListMessagesAction::class)
    ->add(new QueryValidatorMiddleware(__DIR__ . '/../docs/message/request/list.json'));

$app->get('/messages/archived', Message\ListArchivedMessagesAction::class)
    ->add(new QueryValidatorMiddleware(__DIR__ . '/../docs/message/request/archived_list.json'));

$app->get('/messages/{uid}', Message\ShowMessageAction::class);
$app->put('/messages/{uid}/archive', Message\ArchiveMessageAction::class);
$app->put('/messages/{uid}/read', Message\ReadMessageAction::class);
