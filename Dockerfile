FROM chialab/php:7.4

WORKDIR /app

# memcache config
RUN echo 'memcached.sess_locking=0' >> /usr/local/etc/php/php.ini
RUN echo 'memcached.serializer=php' >> /usr/local/etc/php/php.ini
RUN echo 'session.save_handler=memcached' >> /usr/local/etc/php/php.ini
RUN echo 'session.save_path=127.0.0.1:11211' >> /usr/local/etc/php/php.ini

# debug config
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.remote_host=$(ip route show | awk '/default/ {print $3}')" >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/php.ini
