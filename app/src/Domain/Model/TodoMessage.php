<?php

declare(strict_types=1);

namespace App\Domain\Model;

class TodoMessage
{
    /** @var string **/
    private $message;

    private function __construct(string $messages)
    {
        $this->message = $messages;
    }

    public static function fromString(string $message): self
    {
        return new self($message);
    }

    public function value(): string
    {
        return $this->message;
    }
}
