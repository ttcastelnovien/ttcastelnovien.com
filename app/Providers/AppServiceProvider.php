<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Money\Money;
use NumberFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        $url->forceScheme('https');

        Blade::stringable(function (Money $money) {
            $numberFormatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);

            return $numberFormatter->formatCurrency(floatval((int) $money->getAmount() / 100), config('money.defaultCurrency'));
        });
    }
}
