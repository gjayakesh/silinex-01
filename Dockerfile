FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y libsqlite3-dev unzip && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN cd silinex-cms && composer install --no-dev --no-interaction

# Setup the SQLite database
RUN cd silinex-cms && php setup_db.php

# Expose web port
EXPOSE 8080

# Start the built‑in PHP server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app/silinex-cms", "/app/silinex-cms/router.php"]
