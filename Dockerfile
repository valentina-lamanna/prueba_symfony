ARG PHP_VERSION=7.4

FROM registry.frba.utn.edu.ar/apache-php:${PHP_VERSION}

ARG SYMFONY_VERSION=5.4.11

USER root

RUN chown -R www-data:www-data /var/www

WORKDIR /var/www/html

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename composer
RUN php -r "unlink('composer-setup.php');"

RUN apt-get install unzip

RUN apt-get install nano

USER www-data

RUN composer create-project symfony/skeleton symfony "~${SYMFONY_VERSION}"

WORKDIR symfony

RUN composer -n require annotations symfony/apache-pack symfony/security-bundle symfony/monolog-bundle symfony/swiftmailer-bundle symfony/validator symfony/mailer
RUN composer require symfony/maker-bundle phpunit/phpunit symfony/test-pack --dev
RUN composer require orm
RUN composer require symfony/orm-pack
RUN composer require doctrine/doctrine-bundle
RUN composer require symfony/http-client

USER root

COPY site.conf /etc/apache2/sites-enabled/000-default.conf
RUN service apache2 restart

EXPOSE 80