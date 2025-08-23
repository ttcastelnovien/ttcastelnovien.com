<?php

declare(strict_types=1);

namespace App\Services\OFXParser\ValueObjects;

use App\Services\OFXParser\Enums\StatusCode;
use SimpleXMLElement;

final readonly class Status
{
    public StatusCode $code;

    public string $severity;

    public ?string $message;

    public function __construct(
        SimpleXMLElement|string $code,
        SimpleXMLElement|string $severity,
        SimpleXMLElement|string|null $message,
    ) {
        $this->code = StatusCode::from((string) $code);
        $this->severity = (string) $severity;
        $this->message = $message ? (string) $message : null;
    }
}
