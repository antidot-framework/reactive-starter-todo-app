<?php

declare(strict_types=1);

namespace App\Application\Http\Handler;

use Antidot\React\PSR15\Response\PromiseResponse;
use App\Domain\TodoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;
use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;

use function React\Promise\resolve;

class HomePage implements RequestHandlerInterface
{
    private $templateEngine;
    private $repository;

    public function __construct(Environment $template, TodoRepository $repository)
    {
        $this->templateEngine = $template;
        $this->repository = $repository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new PromiseResponse($this->repository
            ->findAll()
            ->then(function (QueryResult $queryResult) {
                return resolve(new HtmlResponse($this->templateEngine->render('index.html.twig', [
                    'todos' => $queryResult->resultRows,
                ])));
            }));
    }
}
