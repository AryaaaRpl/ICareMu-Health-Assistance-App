FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libicu-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_pgsql mbstring intl opcache bcmath \
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

RUN useradd -m -s /bin/bash sail || true

EXPOSE 9000
CMD ["php-fpm"]
