<?php

declare(strict_types=1);

namespace App\Application\Http\Request;

class AddTodoRequest
{
    /** @var string **/
    private $message;

    private function __construct(string $message)
    {
        $this->message = $message;
    }

    public static function withMessage(string $message): self
    {
        return new self($message);
    }

    public function message(): string
    {
        return $this->message;
    }
}
