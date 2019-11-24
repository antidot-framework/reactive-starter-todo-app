<?php

declare(strict_types=1);

namespace App\Domain\Model;

class TodoStatus
{
    public const PENDING_STATUS = 'pending';
    public const DONE_STATUS = 'done';
    public const AVAILABLE_STATUSES = [
        self::PENDING_STATUS,
        self::DONE_STATUS,
    ];
    /** @var string **/
    private $status;

    private function __construct(string $status)
    {
        $this->status = $status;
    }

    public static function createStatus(string $status = self::PENDING_STATUS): self
    {
        return new self($status);
    }

    public function value(): string
    {
        return $this->status;
    }

    public function equalTo(TodoStatus $otherStatus): bool
    {
        return $this->value() === $otherStatus->value();
    }
}
