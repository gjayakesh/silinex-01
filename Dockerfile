FROM php:8.2-cli
WORKDIR /app
COPY . .
RUN cd silinex-cms && php composer.phar install --no-dev
RUN php silinex-cms/setup_db.php
EXPOSE 8080
CMD ["php", "-S", "0.0.0.0:8080", "-t", "silinex-cms", "silinex-cms/router.php"]
