FROM php:8.2-fpm

#
#--------------------------------------------------------------------------
# Core Software's Installation
#--------------------------------------------------------------------------
#

RUN apt-get -qy update && DEBIAN_FRONTEND=noninteractive apt-get -qy install --no-install-recommends \
		zip unzip \
        wget curl \
        libpq-dev \
		libicu-dev \
		nginx runit \
		librabbitmq-dev \
		libssl-dev tcl-dev gettext git ssh \
		bash vim procps net-tools gosu && \
		apt-get autoremove -qy && apt-get clean -qy && \
		rm -rf /tmp/* /var/tmp/* /var/lib/apt/lists/* /etc/nginx/conf.d/* /etc/nginx/sites-enabled/* /etc/nginx/sites-available/*

# END Core Software's Installation  -------------

#
#--------------------------------------------------------------------------
# PHP Installation
#--------------------------------------------------------------------------
#
RUN echo "docker-php-ext-install"     && \
    docker-php-ext-install bcmath     && \
    docker-php-ext-install opcache    && \
    docker-php-ext-install pcntl      && \
    docker-php-ext-configure intl &&  \
    docker-php-ext-install intl

#RUN  pecl install -o -f xdebug && docker-php-ext-enable xdebug && \
#    rm -rf /tmp/* /var/tmp/* /var/lib/apt/lists/*

# END PHP Installation --------------------------

#
#--------------------------------------------------------------------------
# nginx & runit Configuration
#--------------------------------------------------------------------------
#

ADD ./configs/nginx.microservice.conf /etc/nginx/sites-enabled/
ADD ./configs/nginx.conf /etc/nginx/
ADD	./service/ /etc/service/
RUN	touch /etc/inittab && \
    rm -rf /etc/nginx/conf.d/* && \
	chmod +x /etc/service/*/run

ADD ./50-custom.ini         /usr/local/etc/php/conf.d/

# Installing Composer
RUN printf "\nInstalling Composer\n\n"; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer.phar; \
    rm composer-setup.php

ADD ./composer.sh        /usr/local/sbin/composer
RUN sed -i 's/\r//'  /usr/local/sbin/composer && \
    chmod +x         /usr/local/sbin/composer

RUN apt-get update && apt-get install -y libcurl3-dev && docker-php-ext-install curl

ENV PATH /var/www:$PATH

# ubuntu >= 16.10
ARG PUID=1000
ENV PUID ${PUID}
RUN if [ -n "${PUID}" ] && [ "${PUID%:*}" != 0 ]; then \
  usermod -u ${PUID} www-data >/dev/null 2>&1 \
;fi

WORKDIR /var/www

ARG PORT=80
EXPOSE $PORT

ENTRYPOINT ["runsvdir", "-P", "/etc/service"]
