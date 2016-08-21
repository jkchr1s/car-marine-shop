FROM php:7-cli

RUN apt-get update
RUN apt-get install -y git-core unzip

RUN docker-php-ext-install pdo pdo_mysql mbstring


RUN curl https://raw.githubusercontent.com/composer/getcomposer.org/1b137f8bf6db3e79a38a5bc45324414a6b1f9df2/web/installer | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

RUN useradd --user-group --create-home --shell /bin/false app

ENV HOME=/home/app

COPY . $HOME/
RUN chown -R app:app $HOME

USER app

WORKDIR $HOME/

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
