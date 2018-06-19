FROM php:5.6-apache
WORKDIR "/var/www/html"

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get install -y zlib1g-dev libicu-dev g++ libpng-dev libmcrypt-dev libxslt-dev libssl-dev \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Instal git and curl
RUN apt-get update \
    && apt-get install -y git curl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl mcrypt mysql xsl zip pdo_mysql mbstring \
    pcntl gettext bcmath gd