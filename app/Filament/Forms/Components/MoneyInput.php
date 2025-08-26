<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Money\Currency;

class MoneyInput extends TextInput
{
    private ?Currency $currency = null;

    protected function setUp(): void
    {
        $this
            ->mask(RawJs::make(<<<'JS'
                $money($input, ',', ' ', 2)
            JS
            ))
            ->suffix('EUR')
            ->formatStateUsing(fn ($state) => $this->hydrateCurrency($state))
            ->dehydrateStateUsing(fn ($state) => $this->dehydrateCurrency($state));
    }

    protected function hydrateCurrency($state): ?string
    {
        if ($state === null || $state === '') {
            return null;
        }

        $money = money(
            amount: $state['amount'],
            currency: $this->getCurrency(),
            locale: config('app.locale'),
        );

        return $money->format();
    }

    protected function dehydrateCurrency($state): ?string
    {
        if ($state === null || $state === '') {
            return null;
        }

        $money = money(
            amount: $state,
            currency: $this->getCurrency(),
            forceDecimals: true,
            locale: config('app.locale'),
        );

        return $money->getAmount();
    }

    protected function getCurrency(): Currency
    {
        if ($this->currency !== null) {
            return $this->currency;
        }

        $this->currency = new Currency(config('money.defaultCurrency'));

        return $this->currency;
    }
}
