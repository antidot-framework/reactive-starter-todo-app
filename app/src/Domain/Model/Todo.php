<?php

declare(strict_types=1);

namespace App\Domain\Model;

use DateTimeImmutable;

class Todo
{
    private TodoId $todoId;
    private TodoMessage $message;
    private DateTimeImmutable $existSince;
    private TodoStatus $status;
    private ?DateTimeImmutable $doneAt;

    private function __construct(
        TodoId $todoId,
        TodoMessage $message,
        TodoStatus $status,
        DateTimeImmutable $existSince,
        ?DateTimeImmutable $doneAt
    ) {
        $this->todoId = $todoId;
        $this->message = $message;
        $this->status = $status;
        $this->existSince = $existSince;
        $this->doneAt = $doneAt;
    }

    public static function fromTodoIdAndMessage(TodoId $todoId, TodoMessage $message): self
    {
        return new self($todoId, $message, TodoStatus::createStatus(), new DateTimeImmutable(), null);
    }

    public static function fromRawData(
        string $todoId,
        string $message,
        string $status,
        DateTimeImmutable $createdAt,
        ?DateTimeImmutable $updatedAt
    ): self {
        return new self(
            TodoId::fromString($todoId),
            TodoMessage::fromString($message),
            TodoStatus::createStatus($status),
            $createdAt,
            $updatedAt
        );
    }

    public function done(): void
    {
        $this->status = TodoStatus::createStatus(TodoStatus::DONE_STATUS);
        $this->doneAt = new DateTimeImmutable();
    }

    public function id(): TodoId
    {
        return $this->todoId;
    }

    public function message(): TodoMessage
    {
        return $this->message;
    }

    public function existSince(): DateTimeImmutable
    {
        return $this->existSince;
    }

    public function status(): TodoStatus
    {
        return $this->status;
    }

    public function doneAt(): ?DateTimeImmutable
    {
        return $this->doneAt;
    }
}
