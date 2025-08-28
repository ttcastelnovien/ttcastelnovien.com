# Versions
FROM dunglas/frankenphp:1-php8.4 AS frankenphp_upstream
FROM oven/bun:latest AS bun_upstream

# Base image
FROM frankenphp_upstream AS frankenphp_base

WORKDIR /app

# persistent / runtime deps
RUN apt-get update && apt-get install -y --no-install-recommends \
    acl \
    file \
    gettext \
    git \
    && rm -rf /var/lib/apt/lists/*;

# Install required PHP extensions
RUN set -eux; \
    install-php-extensions \
        apcu \
        bcmath \
        gd \
        intl \
        opcache \
        pcntl \
        pdo_pgsql \
        pgsql \
        redis \
        xsl \
        zip \
        @composer;

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Transport to use by Mercure (default to Bolt)
ENV MERCURE_TRANSPORT_URL=bolt:///data/mercure.db

ENV PHP_INI_SCAN_DIR=":$PHP_INI_DIR/app.conf.d"

COPY --link frankenphp/conf.d/10-app.ini $PHP_INI_DIR/app.conf.d/
COPY --link frankenphp/Caddyfile /etc/frankenphp/Caddyfile

# Dev image
FROM frankenphp_base AS frankenphp_dev

# Set environment variables for development
ENV APP_ENV=local
ENV XDEBUG_MODE=off
ENV FRANKENPHP_WORKER_CONFIG=watch

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN set -eux; \
    install-php-extensions \
        xdebug \
    ;

COPY --link frankenphp/conf.d/20-app.dev.ini $PHP_INI_DIR/app.conf.d/

RUN curl -fsSL https://bun.sh/install | BUN_INSTALL="/usr" bash;

# Frontend steps
FROM bun_upstream AS bun_deps

WORKDIR /app

COPY --link package.json bun.lock ./

RUN set -eux; \
    bun install --frozen-lockfile; \
    sync;

COPY --link . ./

RUN set -eux; \
    bun run build:ssr; \
    sync;

# Production image
FROM frankenphp_base AS frankenphp_prod

# Set environment variables for production
ENV APP_ENV=prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --link frankenphp/conf.d/20-app.prod.ini $PHP_INI_DIR/app.conf.d/

# prevent the reinstallation of vendors at every changes in the source code
COPY --link composer.* ./
RUN set -eux; \
    composer install --no-cache --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress; \
    sync;

# copy sources
COPY --link . ./

# install and build frontend dependencies
COPY --from=bun_deps /app/public/build ./public/build
COPY --from=bun_deps /app/bootstrap/ssr ./bootstrap/ssr

RUN set -eux; \
    composer dump-autoload --classmap-authoritative --no-dev; sync;

# entrypoint
COPY frankenphp/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
