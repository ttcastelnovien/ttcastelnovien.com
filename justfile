CWD := `docker compose exec php pwd`
PHP := "docker compose exec php"
COMPOSER := PHP + " composer"
ARTISAN := PHP + " php artisan"
BUN := PHP + " bun"

# *******************************
# Application related
# *******************************

# Recompile assets (CSS/JS) on every change
watch:
    {{ BUN }} run dev

# Compile and optimize assets for production
build:
    {{ BUN }} run build

# Launch PHPUnit tests
test *path:
    {{ PHP }} php bin/pest {{ path }}

# *******************************
# Tools related
# *******************************

# Install php dependencies
install_php:
    {{ COMPOSER }} install

# Install frontend dependencies
install_front:
    {{ BUN }} install

# composer alias
composer +arguments:
    COMPOSER_ALLOW_SUPERUSER=1 {{ COMPOSER }} {{ arguments }}

# artisan alias
artisan *arguments:
    {{ ARTISAN }} {{ arguments }}

# php alias
php *arguments:
    {{ PHP }} {{ arguments }}

# bun alias
bun +arguments:
    {{ BUN }} {{ arguments }}

# Install all dependencies
install: install_php install_front

# Review possible dependencies to upgrade
ncu:
    {{ BUN }} run deps:upgrade

# Review possible dependencies to upgrade
outdated:
    {{ COMPOSER }} outdated --strict --direct

first_install:
    {{ COMPOSER }} install --no-interaction --no-progress --optimize-autoloader
    {{ COMPOSER }} run-script post-root-package-install
    {{ ARTISAN }} key:generate --ansi
    {{ ARTISAN }} migrate --no-interaction
    {{ BUN }} install
    PEST_NO_SUPPORT=true {{ COMPOSER }} remove phpunit/phpunit --dev --no-update
    PEST_NO_SUPPORT=true {{ COMPOSER }} require pestphp/pest pestphp/pest-plugin-laravel --no-update --dev
    PEST_NO_SUPPORT=true {{ COMPOSER }} update
    PEST_NO_SUPPORT=true {{ PHP }} ./vendor/bin/pest --init
    PEST_NO_SUPPORT=true {{ COMPOSER }} require pestphp/pest-plugin-drift --dev
    PEST_NO_SUPPORT=true {{ PHP }} ./vendor/bin/pest --drift
    PEST_NO_SUPPORT=true {{ COMPOSER }} remove pestphp/pest-plugin-drift --dev

# *******************************
# Environment related
# *******************************

# Open a shell in the php container
shell:
    docker compose exec -it php bash
