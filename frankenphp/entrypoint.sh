#!/bin/sh
set -e

# Start Inertia in SSR mode
php artisan inertia:start-ssr

# Start FrankenPHP (Octane)
php artisan octane:frankenphp
