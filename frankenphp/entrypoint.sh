#!/bin/sh
set -e

# Optimize Laravel
php artisan optimize;

# Start Inertia in SSR mode
php artisan inertia:start-ssr

# Start FrankenPHP (Octane)
php artisan octane:frankenphp
