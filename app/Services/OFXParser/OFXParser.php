<?php

declare(strict_types=1);

namespace App\Services\OFXParser;

use App\Services\OFXParser\ValueObjects\BankAccount;
use App\Services\OFXParser\ValueObjects\OFXData;
use App\Services\OFXParser\ValueObjects\SignOn;
use App\Services\OFXParser\ValueObjects\Statement;
use App\Services\OFXParser\ValueObjects\Status;
use SimpleXMLElement;

final readonly class OFXParser
{
    /**
     * Parse OFX data and return an associative array with the parsed information.
     *
     * @throws \Exception
     */
    public static function parse(string $ofxData): ?OFXData
    {
        $xml = OFXUtils::normalizeOfx($ofxData);
        if ($xml === false) {
            return null;
        }

        $signOn = self::parseSignOn($xml->SIGNONMSGSRSV1->SONRS);
        $bankAccounts = [];

        foreach ($xml->BANKMSGSRSV1->STMTTRNRS as $accountStatement) {
            foreach ($accountStatement->STMTRS as $statementResponse) {
                $bankAccounts[] = self::parseBankAccount($accountStatement->TRNUID, $statementResponse);
            }
        }

        return new OFXData(
            signOn: $signOn,
            bankAccounts: $bankAccounts,
        );
    }

    /**
     * @throws \Exception
     */
    protected static function parseSignOn(SimpleXMLElement $xml): SignOn
    {
        $status = new Status(
            code: $xml->STATUS->CODE,
            severity: $xml->STATUS->SEVERITY,
            message: $xml->STATUS->MESSAGE,
        );

        return new SignOn(
            status: $status,
            date: $xml->DTSERVER,
            language: $xml->LANGUAGE,
        );
    }

    /**
     * @throws \Exception
     */
    private static function parseBankAccount(SimpleXMLElement|string $uuid, SimpleXMLElement $xml): BankAccount
    {
        $statement = self::parseStatement($xml);

        return new BankAccount(
            routingNumber: $xml->BANKACCTFROM->BANKID,
            agencyNumber: $xml->BANKACCTFROM->BRANCHID,
            accountNumber: $xml->BANKACCTFROM->ACCTID,
            accountType: $xml->BANKACCTFROM->ACCTTYPE,
            balance: $xml->LEDGERBAL->BALAMT,
            balanceDate: $xml->LEDGERBAL->DTASOF,
            statement: $statement,
            transactionUid: $uuid,
        );
    }

    /**
     * @throws \Exception
     */
    private static function parseStatement(SimpleXMLElement $xml): Statement
    {
        return new Statement(
            currency: $xml->CURDEF,
            startDate: $xml->BANKTRANLIST->DTSTART,
            endDate: $xml->BANKTRANLIST->DTEND,
            transactions: $xml->BANKTRANLIST->STMTTRN,
        );
    }
}
