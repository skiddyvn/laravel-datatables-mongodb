FROM php:8.2-cli

# Install system deps
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libssl-dev libcurl4-openssl-dev libonig-dev libxml2-dev \
    libicu-dev libpq-dev gnupg curl libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip
RUN pecl install mongodb && docker-php-ext-enable mongodb
# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy everything
COPY . .

# Install PHP deps
RUN composer install

# RUN git config --global --add safe.directory /app
