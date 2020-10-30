#!/bin/bash

NAME_PREFIX="$1"

# ensure that old containers are removed
docker-compose -p $NAME_PREFIX down -v --rmi local
