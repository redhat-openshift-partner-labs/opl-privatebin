FROM alpine:3.13

LABEL Maintainer="Lifecycle Engineering <sd-ecosystem@redhat.com>" \
      Description="Container with nginx 1.20, php-fpm 8.0, and PrivateBin 1.3.5 based on Alpine Linux 3.12"

#ADD https://dl.bintray.com/php-alpine/key/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub

# make sure you can use HTTPS
RUN apk --update add ca-certificates

RUN echo "https://dl.bintray.com/php-alpine/v3.12/php-8.0" >> /etc/apk/repositories

# Install packages
RUN apk --no-cache add gnupg nginx php8-fpm php8-json php8-gd supervisor curl \
    php8-opcache php8-pdo_mysql php8-pdo_pgsql s6-overlay tzdata

#RUN apk --no-cache add php8 php8-fpm php8-opcache php8-openssl php8-curl zlib-dev zlib \
#    php8-gd php8-pdo php8-pdo_mysql php8-pdo_pgsql php8-mysqlnd php8-zlib nginx supervisor curl

RUN apk upgrade --no-cache

# https://github.com/codecasts/php-alpine/issues/21
#RUN ln -s /usr/bin/php7 /usr/bin/php

# Configure nginx
# COPY config/nginx.conf /etc/nginx/nginx.conf
RUN rm -rf /etc/nginx
COPY config/nginx /etc/nginx

# Remove default server definition
# RUN rm /etc/nginx/conf.d/default.conf

# Configure PHP-FPM
#COPY config/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
#COPY config/php.ini /etc/php7/conf.d/custom.ini
RUN rm -rf /etc/php8
COPY config/php8 /etc/php8

# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup document root
RUN mkdir -p /var/www

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody:www-data /var/www && \
  chown -R nobody:www-data /tmp && \
  chown -R nobody:www-data /var/lib/nginx && \
  chown -R nobody:www-data /var/log/nginx && \
  chown -R nobody:www-data /etc/s6

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /var/www
COPY --chown=nobody src/ /var/www/

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --fail -u dev:dev http://localhost:8080 || exit 1
