FROM ubuntu:14.04

RUN apt-get update

# Install git, curl & telnet.
RUN apt-get install -y telnet git curl

# Add support for add-apt-repository
RUN apt-get install -y software-properties-common

# Point at the PHP PPA
RUN apt-get install -y language-pack-en-base
RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php
RUN add-apt-repository -y ppa:ondrej/php

RUN apt-get update

# Install PHP
RUN apt-get install -y php7.0

# Install PHP with MySQL, Mcrypt & Redis.
RUN apt-get install -y php7.0-mysql php7.0-mcrypt php7.0-redis

# Installs the php mbstring package needed by laravel
RUN apt-get install -y php7.0-mbstring
RUN apt-get install -y php7.0-xml
RUN apt-get install -y php7.0-zip

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
# Put composer on the path.
ENV PATH "$PATH:/var/www/html/vendor/bin"

# Export port 80.
EXPOSE 80

# Copy source code into place.
COPY src/ /var/www/html/

# Setup the laravel website Apache configuration
COPY docker/0-laravel.conf /etc/apache2/sites-available/0-laravel.conf
WORKDIR /etc/apache2/sites-enabled
RUN ln -s /etc/apache2/sites-available/0-laravel.conf
RUN ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
COPY docker/rewrite.conf /etc/apache2/mods-available/rewrite.conf

# Make laravel's scratch directories writeable.
RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/bootstrap/cache

# Install apache.
RUN apt-get install -y apache2

# Set the initial working directory.
WORKDIR /var/www/html

# Start apache in the foreground.
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
