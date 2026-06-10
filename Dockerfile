FROM php:8.2-cli

RUN apt-get update && apt-get install -y libsqlite3-dev && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_sqlite

WORKDIR /app

COPY . .

RUN cd silinex-cms && php composer.phar install --no-dev --no-interaction

RUN php silinex-cms/setup_db.php

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app/silinex-cms", "/app/silinex-cms/router.php"]
