<?php

declare(strict_types=1);

use Antidot\Application\Http\Application;
use App\Application\Http\Handler\AddTodo;
use App\Application\Http\Handler\DoneTodo;
use App\Application\Http\Handler\HomePage;
use App\Application\Http\Handler\RemoveTodo;
use App\Application\Http\Middleware\AddTodoValidator;
use Psr\Container\ContainerInterface;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 */
return static function (Application $app, ContainerInterface $container) : void {
    $app->get('/', [HomePage::class], 'home');
    $app->post('/todos/add', [AddTodoValidator::class, AddTodo::class], 'add_todo');
    $app->post('/todos/{todo_id}/done', [DoneTodo::class], 'done_todo');
    $app->post('/todos/{todo_id}/remove', [RemoveTodo::class], 'remove_todo');
};
