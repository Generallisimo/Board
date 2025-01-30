FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


COPY ./Exchange_Board /var/www/Exchange_Board

WORKDIR /var/www/Exchange_Board

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin
RUN echo "alias a='artisan'" >> /root/.bashrc

RUN apt-get update && apt-get install -y supervisor
COPY ./Exchange_Board/_docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

RUN node -v && npm -v
RUN npm install

RUN composer install \
      --no-interaction \
      --no-plugins \
      --no-suggest \
      --optimize-autoloader \
      --prefer-dist


RUN composer dump-autoload  --no-scripts --optimize && \
    chown -R root:www-data /var/www && \
    chmod 755 -R /var/www/Exchange_Board && \
    chmod -R 775 /var/www/Exchange_Board/storage && \
    chmod -R 775 /var/www/Exchange_Board/bootstrap/cache



CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]