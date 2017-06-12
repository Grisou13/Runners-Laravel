# Workflow

Here are a couple of commands we use all the time

## Reset database

If you already have data and need to rerun seeders
`php artisan db:reset`

Make sur you check
`php artisan help db:reset`
For more help

## Interact with the app on docker

That's very simple, just run
`docker-compose run --rm app bash`

Now you are in an interactive console that can has access to php

_You could also use `docker-compose run --rm app php artisan {command here}`_