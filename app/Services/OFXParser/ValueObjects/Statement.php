<?php

declare(strict_types=1);

namespace App\Services\OFXParser\ValueObjects;

use App\Services\OFXParser\Enums\DateFormat;
use App\Services\OFXParser\OFXUtils;
use Illuminate\Support\Carbon;
use Money\Currency;
use SimpleXMLElement;

final readonly class Statement
{
    public Currency $currency;

    /** @var list<Transaction> */
    public array $transactions;

    public Carbon $startDate;

    public Carbon $endDate;

    public function __construct(
        SimpleXMLElement|string $currency,
        SimpleXMLElement|string $startDate,
        SimpleXMLElement|string $endDate,
        SimpleXMLElement $transactions,
    ) {
        $this->currency = new Currency((string) $currency);
        $this->startDate = OFXUtils::parseDate($startDate, DateFormat::DATETIME);
        $this->endDate = OFXUtils::parseDate($endDate, DateFormat::DATETIME);

        $normalizedTransactions = [];
        foreach ($transactions as $transaction) {
            $normalizedTransactions[] = new Transaction(
                currency: $this->currency,
                type: $transaction->TRNTYPE,
                date: $transaction->DTPOSTED,
                amount: $transaction->TRNAMT,
                uniqueId: $transaction->FITID,
                name: $transaction->NAME,
                memo: $transaction->MEMO,
            );
        }
        $this->transactions = $normalizedTransactions;
    }
}
