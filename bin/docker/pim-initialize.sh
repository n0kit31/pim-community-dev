#!/usr/bin/env bash

docker-composer exec akeneo --env=prod cache:clear --no-warmup
docker-composer exec akeneo --env=dev cache:clear --no-warmup
docker-composer exec akeneo-behat --env=behat cache:clear --no-warmup
docker-composer exec akeneo-behat --env=test cache:clear --no-warmup

docker-compose exec akeneo app/console --env=prod pim:install --force --symlink
docker-compose exec akeneo-behat app/console --env=behat pim:installer:db