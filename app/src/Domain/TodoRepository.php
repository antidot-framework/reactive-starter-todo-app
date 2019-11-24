<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\Todo;
use App\Domain\Model\TodoId;
use React\Promise\PromiseInterface;

interface TodoRepository
{
    public function findAll(): PromiseInterface;
    public function get(TodoId $todoId): PromiseInterface;
    public function save(Todo $todo): PromiseInterface;
    public function remove(TodoId $fromString): PromiseInterface;
}
