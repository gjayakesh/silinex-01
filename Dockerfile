# Dockerfile for Silinex-CMS (PHP 8.2 + Apache)
# ---------------------------------------------------
FROM php:8.2-apache

# Install system packages needed for SQLite and Composer
RUN apt-get update && apt-get install -y \
        libsqlite3-dev \
        unzip \
        git \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Set working directory to Apache's document root
WORKDIR /var/www/html

# Copy the CMS source into the container
COPY silinex-cms/ .

# Install Composer (official installer)
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer

# Install project dependencies (no dev dependencies)
RUN composer install --no-dev --prefer-dist

# Run DB setup during image build (creates SQLite DB)
RUN php setup_db.php

# Expose the HTTP port (Apache listens on 80)
EXPOSE 80

# The base image already defines the CMD to run Apache in the foreground
