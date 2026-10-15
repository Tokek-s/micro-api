FROM php:8.2-cli-alpine

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --no-scripts --optimize-autoloader

COPY . .
RUN rm -f bootstrap/cache/*.php \
    && composer dump-autoload --no-dev --optimize --no-scripts \
    && addgroup -S appgroup \
    && adduser -S appuser -G appgroup \
    && chown -R appuser:appgroup storage bootstrap/cache

ARG APP_PORT=8000
EXPOSE ${APP_PORT}

USER appuser

CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${APP_PORT:-8000}"]