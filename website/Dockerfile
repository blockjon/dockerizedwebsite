FROM ubuntu:1404
COPY src/ /var/www/html/
EXPOSE 80

COPY docker/0-laravel.conf /etc/apache2/sites-available/0-laravel.conf
WORKDIR /etc/apache2/sites-enabled
RUN ln -s /etc/apache2/sites-available/0-laravel.conf

RUN apt-get update

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Install add-apt-repository support
RUN apt-get install -y git

RUN apt-get install -y telnet

ENV PATH "$PATH:/var/www/html/vendor/bin"

# Install zip abilities.
RUN apt-get update \
&& apt-get install -y zlib1g-dev \
&& rm -rf /var/lib/apt/lists/* \
&& docker-php-ext-install zip

WORKDIR /var/www/html

RUN chmod -R 777 /var/www/html/website/storage
RUN chmod -R 777 /var/www/html/website/bootstrap/cache
