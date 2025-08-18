<?php

declare(strict_types=1);

namespace App\Services\OFXParser\ValueObjects;

use App\Services\OFXParser\Enums\DateFormat;
use App\Services\OFXParser\OFXUtils;
use Illuminate\Support\Carbon;
use SimpleXMLElement;

final readonly class SignOn
{
    public Status $status;

    public Carbon $date;

    public string $language;

    public function __construct(
        Status $status,
        SimpleXMLElement|string $date,
        SimpleXMLElement|string $language,
    ) {
        $this->status = $status;
        $this->date = OFXUtils::parseDate((string) $date, DateFormat::DATETIME);
        $this->language = (string) $language;
    }
}
