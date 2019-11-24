<?php

declare(strict_types=1);

namespace App\Application\Http\Middleware;

use Antidot\React\PSR15\Response\PromiseResponse;
use App\Application\Http\Request\AddTodoRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use React\Promise\FulfilledPromise;
use Webmozart\Assert\Assert;

class AddTodoValidator implements MiddlewareInterface
{
    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $promise = new FulfilledPromise($request);

        return new PromiseResponse(
            $promise
                ->then(static function (ServerRequestInterface $request) {
                    $form = $request->getParsedBody();
                    Assert::notEmpty($form);
                    Assert::keyExists($form, 'todo_message');

                    return AddTodoRequest::withMessage($form['todo_message']);
                })
                ->then(static function (AddTodoRequest $todoRequest) use ($request, $handler) {
                    $request = $request->withAttribute('todo_message', $todoRequest);

                    return $handler->handle($request);
                })
        );
    }
}
