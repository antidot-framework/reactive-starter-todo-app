<?php

declare(strict_types=1);

namespace App\Domain\Model;

class TodoId
{
    /** @var string **/
    private $todoId;

    private function __construct(string $todoId)
    {
        $this->todoId = $todoId;
    }

    public static function fromString(string $todoId): self
    {
        return new self($todoId);
    }

    public function value(): string
    {
        return $this->todoId;
    }
}
