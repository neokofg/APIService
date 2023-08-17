FROM php:8.2.0-fpm
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install pdo pdo_mysql
WORKDIR /workspace
ENV DB_HOST mysql
CMD ["php-fpm"]
