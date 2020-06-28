FROM php:7.4.3-fpm

RUN apt-get update && apt-get install -y git zip zlib1g-dev libicu-dev g++ libxml2-dev autoconf pkg-config librabbitmq-dev libssh-dev libonig-dev

RUN docker-php-ext-install pdo_mysql bcmath iconv pcntl mbstring intl calendar sockets

RUN pecl install -o -f redis \
&& rm -rf /tmp/pear \
&& docker-php-ext-enable redis \
&& pecl install amqp \
&& rm -rf /tmp/pear \
&& docker-php-ext-enable amqp

COPY ./conf.d/redis.ini $PHP_INI_DIR/conf.d/redis.ini

ADD ./wait-for-mysql.sh /opt/wait-for-mysql.sh
RUN chmod +x /opt/wait-for-mysql.sh

CMD ["/opt/wait-for-mysql.sh", "php"]
