<?php

declare(strict_types=1);

namespace App\Services\OFXParser\ValueObjects;

use App\Services\OFXParser\OFXUtils;
use Illuminate\Support\Carbon;
use Money\Money;
use SimpleXMLElement;

final readonly class BankAccount
{
    public string $accountNumber;

    public string $accountType;

    public Money $balance;

    public Carbon $balanceDate;

    public string $routingNumber;

    public Statement $statement;

    public string $transactionUid;

    public string $agencyNumber;

    public function __construct(
        SimpleXMLElement|string $routingNumber,
        SimpleXMLElement|string $agencyNumber,
        SimpleXMLElement|string $accountNumber,
        SimpleXMLElement|string $accountType,
        SimpleXMLElement|string $balance,
        SimpleXMLElement|string $balanceDate,
        Statement $statement,
        SimpleXMLElement|string $transactionUid,
    ) {
        $this->routingNumber = (string) $routingNumber;
        $this->agencyNumber = (string) $agencyNumber;
        $this->accountNumber = (string) $accountNumber;
        $this->accountType = (string) $accountType;
        $this->balance = OFXUtils::parseMoney($balance);
        $this->balanceDate = OFXUtils::parseDate((string) $balanceDate);
        $this->statement = $statement;
        $this->transactionUid = (string) $transactionUid;
    }
}
