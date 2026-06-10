FROM php:8.2-cli

# Install SQLite extension
RUN docker-php-ext-install pdo pdo_sqlite

WORKDIR /app

#  everything
COPY . .

# Install Composer dependencies
RUN cd silinex-cms && php composer.phar install --no-dev --no-interaction

# Create the SQLite database
RUN php silinex-cms/setup_db.php

EXPOSE 8080

# Start PHP built-in server (same as your local command)
CMD ["php", "-S", "0.0.0.0:8080", \
     "-t", "/app/silinex-cms", \
     "/app/silinex-cms/router.php"]
Copy
