<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Model\Todo;
use App\Domain\Model\TodoId;
use App\Domain\TodoRepository;
use DateTimeImmutable;
use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

class MysqlTodoRepository implements TodoRepository
{
    /** @var ConnectionInterface **/
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function save(Todo $todo): PromiseInterface
    {
        $query = <<<SQL
REPLACE INTO todos (todo_id, message, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?);
SQL;

        return $this->connection->query($query, [
            $todo->id()->value(),
            $todo->message()->value(),
            $todo->status()->value(),
            $todo->existSince()->format('Y-m-d H:i:s'),
            $todo->doneAt() ? $todo->doneAt()->format('Y-m-d H:i:s') : null,
        ]);
    }

    public function get(TodoId $todoId): PromiseInterface
    {
        $query = <<<SQL
SELECT * FROM todos WHERE todo_id = ?;
SQL;

        return $this->connection->query($query, [
            $todoId->value(),
        ])->then(function (QueryResult $queryResult) {
            $todo = $queryResult->resultRows[0];

            return Todo::fromRawData(
                $todo['todo_id'],
                $todo['message'],
                $todo['status'],
                new DateTimeImmutable($todo['created_at']),
                empty($todo['updated_at']) ? null : new DateTimeImmutable($todo['updated_at'])
            );
        });
    }

    public function findAll(): PromiseInterface
    {
        $query = <<<SQL
SELECT * FROM todos ORDER BY created_at DESC;
SQL;

        return $this->connection->query($query);
    }

    public function remove(TodoId $todoId): PromiseInterface
    {
        $query = <<<SQL
DELETE FROM todos WHERE todo_id = ?;
SQL;

        return $this->connection->query($query, [$todoId->value()]);
    }
}
