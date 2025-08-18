<?php

declare(strict_types=1);

namespace App\Services\OFXParser\ValueObjects;

final readonly class OFXData
{
    public Status $status;

    /** @var list<BankAccount> */
    public array $bankAccounts;

    public function __construct(
        SignOn $signOn,
        array $bankAccounts,
    ) {
        $this->status = $signOn->status;
        $this->bankAccounts = $bankAccounts;
    }
}
