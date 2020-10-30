#!/bin/bash

NAME_PREFIX="$1"

# ensure that old containers are removed
docker-compose -p $NAME_PREFIX stop
docker-compose -p $NAME_PREFIX rm -f

# start application
docker-compose -p $NAME_PREFIX build --pull
docker-compose -p $NAME_PREFIX up -d --force-recreate