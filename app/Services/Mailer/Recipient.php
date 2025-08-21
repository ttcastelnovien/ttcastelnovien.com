<?php

declare(strict_types=1);

namespace App\Services\Mailer;

final readonly class Recipient
{
    public function __construct(
        public string $email,
        public string $name = '',
    ) {}

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
        ];
    }
}
