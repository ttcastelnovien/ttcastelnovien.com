<?php

declare(strict_types=1);

namespace App\Services\OFXParser;

use App\Services\OFXParser\Enums\DateFormat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use RuntimeException;
use SimpleXMLElement;

final readonly class OFXUtils
{
    public static function normalizeOfx(string $ofxContent): string|false|SimpleXMLElement
    {
        $ofxContent = str_replace(['\r\n'], '\n', $ofxContent);
        // $ofxContent = mb_convert_encoding($ofxContent, 'UTF-8', 'ISO-8859-1');
        $sgmlStart = stripos($ofxContent, '<OFX>');
        $ofxSgml = trim(substr($ofxContent, $sgmlStart));
        $ofxXml = self::convertSgmlToXml($ofxSgml);
        libxml_clear_errors();
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($ofxXml);

        if ($errors = libxml_get_errors()) {
            throw new RuntimeException('Failed to parse OFX: '.var_export($errors, true));
        }

        return $xml;
    }

    private static function convertSgmlToXml($sgml): string
    {
        $sgml = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $sgml);

        $lines = explode("\n", $sgml);
        $tags = [];

        foreach ($lines as $i => &$line) {
            $line = trim(self::closeUnclosedXmlTags($line))."\n";

            /*
            |--------------------------------------------------------------------------
            | Matches open or closing tags like <SOMETHING> or </SOMETHING>
            |--------------------------------------------------------------------------
            */
            if (! preg_match('/^<(\/?[A-Za-z0-9.]+)>$/', trim($line), $matches)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | If matches </SOMETHING>, looks back and replaces all tags like
            | <OTHERTHING> to <OTHERTHING/> until finds the opening tag <SOMETHING>
            |--------------------------------------------------------------------------
            */
            if ($matches[1][0] == '/') {
                $tag = substr($matches[1], 1);

                while (($last = array_pop($tags)) && $last[1] != $tag) {
                    $lines[$last[0]] = "<$last[1]/>";
                }
            } else {
                $tags[] = [$i, $matches[1]];
            }
        }

        return implode("\n", array_map('trim', $lines));
    }

    private static function closeUnclosedXmlTags($line): string
    {
        // Special case discovered where the empty content tag wasn't closed
        $line = trim($line);
        if (preg_match('/<MEMO>$/', $line) === 1) {
            return '<MEMO></MEMO>';
        }

        /*
        |--------------------------------------------------------------------------
        | Matcher for closing open tags.
        | Will match: <SOMETHING>blah
        | Will not match: <SOMETHING>
        | Will not match: <SOMETHING>blah</SOMETHING>
        |--------------------------------------------------------------------------
        */
        if (preg_match(
            "/<([A-Za-z0-9.]+)>([\wà-úÀ-Ú0-9.\-_+, ;:\[\]'&\/\\\*()+{|}!£\$?=@€£#%±§~`\"]+)$/",
            $line,
            $matches
        )) {
            return "<$matches[1]>$matches[2]</$matches[1]>";
        }
        return $line;
    }

    /**
     * Parse a date string and return a Carbon instance.
     *
     * @throws \Exception
     */
    public static function parseDate(SimpleXMLElement|string $dateString, DateFormat $format = DateFormat::DATE): Carbon
    {
        try {
            $date = Date::createFromFormat($format->value, (string) $dateString);

            if ($format === DateFormat::DATE) {
                return $date
                    ->shiftTimezone('Europe/Paris')
                    ->startOfDay();
            }

            return $date->shiftTimezone('Europe/Paris');
        } catch (\Exception) {
            throw new \Exception("Invalid date format: (string) $dateString");
        }
    }

    public static function parseMoney(SimpleXMLElement|string $amount, ?Currency $currency = null): Money
    {
        $currencies = new ISOCurrencies;
        $moneyParser = new DecimalMoneyParser($currencies);

        if ($currency === null) {
            $currency = new Currency('EUR');
        }

        $normalizedAmount = ltrim((string) $amount, '+');
        return $moneyParser->parse($normalizedAmount, $currency);
    }
}
