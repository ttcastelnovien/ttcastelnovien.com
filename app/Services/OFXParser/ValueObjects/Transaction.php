<?php

declare(strict_types=1);

namespace App\Services\OFXParser\ValueObjects;

use App\Services\OFXParser\Enums\TransactionType;
use App\Services\OFXParser\OFXUtils;
use Illuminate\Support\Carbon;
use Money\Currency;
use Money\Money;
use SimpleXMLElement;

final readonly class Transaction
{
    public Currency $currency;

    public TransactionType $type;

    public Money $amount;

    public Carbon $date;

    public string $uniqueId;

    public string $name;

    public string $memo;

    public function __construct(
        Currency $currency,
        SimpleXMLElement|string $type,
        SimpleXMLElement|string $date,
        SimpleXMLElement|string $amount,
        SimpleXMLElement|string $uniqueId,
        SimpleXMLElement|string $name,
        SimpleXMLElement|string $memo,
    ) {
        $this->currency = $currency;
        $this->type = TransactionType::from((string) $type);
        $this->date = OFXUtils::parseDate((string) $date);
        $this->uniqueId = (string) $uniqueId;
        $this->name = (string) $name;
        $this->memo = (string) $memo;

        $this->amount = OFXUtils::parseMoney($amount, $this->currency);
    }
}
