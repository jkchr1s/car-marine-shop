#!/bin/bash

# create the network
NETCHECK=`docker network ls | grep localdev`
if [ -z "$NETCHECK" ]; then
  docker network create localdev
fi

# maria db
MARIACHECK=`docker images | grep mariadb`
if [ -z "$MARIACHECK" ]; then
  docker run --net=localdev --name mariadb -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=site -e MYSQL_USER=site -e MYSQL_PASSWORD=test -d mariadb:latest
fi

# build the project image
docker build -t whitepeels:latest .

# create the container
docker create --name=whitepeels --net=localdev -p 8000:8000 -v $(pwd):/home/app whitepeels:latest
docker run --name=whitepeels-temp -v $(pwd):/home/app whitepeels /usr/local/bin/composer install
docker rm whitepeels-temp
rm -rf .composer
docker start whitepeels
docker exec whitepeels /usr/local/bin/php /home/app/artisan key:generate
docker exec whitepeels /usr/local/bin/php /home/app/artisan migrate
docker exec whitepeels /usr/local/bin/php /home/app/artisan db:seed
