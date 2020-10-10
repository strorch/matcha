FROM chialab/php:7.4-apache

WORKDIR /app

# memcache config
RUN echo 'memcached.sess_locking=0' >> /usr/local/etc/php/php.ini
RUN echo 'memcached.serializer=php' >> /usr/local/etc/php/php.ini
RUN echo 'session.save_handler=memcached' >> /usr/local/etc/php/php.ini
RUN echo 'session.save_path=127.0.0.1:11211' >> /usr/local/etc/php/php.ini

# apache2 config
RUN rm /etc/apache2/sites-available/000-default.conf
COPY config/matcha.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod headers
RUN a2enmod rewrite

# debug config
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN apt update && apt install -y dnsutils
RUN echo "xdebug.remote_host=$(dig +short host.docker.internal)" >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini
#apt update && apt install -y iproute2 && ip route show | awk '/default/ {print $3}'
#RUN echo "xdebug.remote_host=192.168.7.101" >> /usr/local/etc/php/php.ini
