<?php

declare(strict_types=1);

namespace App\Application\Http\Handler;

use Antidot\React\PSR15\Response\PromiseResponse;
use App\Application\Http\Middleware\AddTodoValidator;
use App\Application\Http\Request\AddTodoRequest;
use App\Domain\Model\Todo;
use App\Domain\Model\TodoId;
use App\Domain\Model\TodoMessage;
use App\Domain\TodoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;
use Laminas\Diactoros\Response\RedirectResponse;

use function React\Promise\resolve;

class AddTodo implements RequestHandlerInterface
{
    /** @var TodoRepository * */
    private $repository;
    /** @var AddTodoValidator * */
    private $addTodoValidator;

    public function __construct(TodoRepository $repository, AddTodoValidator $todoValidator)
    {
        $this->repository = $repository;
        $this->addTodoValidator = $todoValidator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new PromiseResponse(
            resolve($request)
                ->then(
                    static fn(ServerRequestInterface $request): AddTodoRequest => $request->getAttribute('todo_message')
                )
                ->then(static function (AddTodoRequest $todoRequest): Todo {
                    return Todo::fromTodoIdAndMessage(
                        TodoId::fromString(Uuid::uuid4()->toString()),
                        TodoMessage::fromString($todoRequest->message())
                    );
                })
                ->then(fn (Todo $todo) => $this->repository->save($todo))
                ->then(fn () => new RedirectResponse('/'))
        );
    }
}
