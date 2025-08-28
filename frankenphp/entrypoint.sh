#!/bin/sh
set -e

echo "laravel preparation..."

php artisan optimize --no-ansi
php artisan filament:optimize

cleanup() {
    echo "container stopping..."
    kill -TERM "$OCTANE_PID" 2>/dev/null
    kill -TERM "$SSR_PID" 2>/dev/null
    wait $OCTANE_PID $SSR_PID
    exit 0
}
trap cleanup TERM INT

echo "starting inertia ssr..."
php artisan inertia:start-ssr --no-ansi & SSR_PID=$!

echo "starting frankenphp..."
php artisan octane:frankenphp --no-ansi & OCTANE_PID=$!

wait $OCTANE_PID $SSR_PID
