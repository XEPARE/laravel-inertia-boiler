FROM ghcr.io/rene-roscher/php-docker:php-8.2 AS APP_BASE

WORKDIR /var/www

COPY . /var/www

RUN echo "" > /var/www/storage/logs/laravel.log

RUN chmod -R gu+w storage/ && chmod -R guo+w storage/ && chmod -R gu+w bootstrap/cache/ && chmod -R guo+w bootstrap/cache/

RUN chown -R www-data:www-data /var/www

COPY ./docker/supervisord.conf /etc/supervisord.conf

CMD ["supervisord", "-c", "/etc/supervisord.conf"]