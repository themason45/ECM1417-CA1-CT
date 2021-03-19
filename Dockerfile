FROM php:8.0.3-cli
COPY . /usr/src/covid_tracker
WORKDIR /usr/src/covid_tracker

RUN docker-php-ext-install pdo pdo_mysql

CMD [ "php" ]