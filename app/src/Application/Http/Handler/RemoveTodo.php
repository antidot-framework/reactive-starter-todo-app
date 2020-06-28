<?php

declare(strict_types=1);

namespace App\Application\Http\Handler;

use Antidot\React\PSR15\Response\PromiseResponse;
use App\Domain\Model\TodoId;
use App\Domain\TodoRepository;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function React\Promise\resolve;

class RemoveTodo implements RequestHandlerInterface
{
    /** @var TodoRepository * */
    private $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new PromiseResponse(resolve(
            $this->repository->remove(TodoId::fromString(
                $request->getAttribute('todo_id')
            ))
            ->then(static fn() => new RedirectResponse('/'))
        ));
    }
}
