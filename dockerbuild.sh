#!/bin/bash

# create the network
NETCHECK=`docker network ls | grep localdev`
if [ -z "$NETCHECK" ]; then
  docker network create localdev
fi

# maria db
MARIACHECK=`docker images | grep mariadb`
if [ -z "$MARIACHECK" ]; then
  docker run --net=localdev --name mariadb -e MYSQL_ROOT_PASSWORD=epb123 -e MYSQL_DATABASE=wholesale_mediaroom -e MYSQL_USER=wholesale -e MYSQL_PASSWORD=epb123 -d mariadb:latest
fi

# build the project image
docker build -t wholesale-mediaroom:latest .

# create the container
docker create --name=wholesale-mediaroom --net=localdev -p 8000:8000 -v $(pwd):/home/app wholesale-mediaroom:latest
docker run --name=wholesale-mediaroom-temp -v $(pwd):/home/app wholesale-mediaroom /usr/local/bin/composer install
docker rm wholesale-mediaroom-temp
rm -rf .composer
docker start wholesale-mediaroom
docker exec wholesale-mediaroom /usr/local/bin/php /home/app/artisan key:generate
docker exec wholesale-mediaroom /usr/local/bin/php /home/app/artisan migrate
