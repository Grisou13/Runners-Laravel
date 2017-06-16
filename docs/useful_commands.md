# Workflow

Here are a couple of commands that you might need to know.

We use these commands all the time.

## Reset database

```
php artisan db:reset
```

If you already have data and need to rerun seeders
`php artisan db:reset`
And if you want to use the production seeds, use `php artisan db:reset --production`.
Use `php artisan help db:reset`
For more help.

## Compiling assets

```
gulp watch
```

We use sass, css, js, babel and alot of great stuff, but we need to compile some of them.

This is why everytime we start developping, we run `gulp watch`

This will compile all the javascript , and sass in `/assets`

Run `npm rebuild node-sass` if you have problems with compiling sass.

## Interact with the app on docker

```
docker-compose run --rm app bash
```

`docker-compose run --rm app bash`
That's very simple, just run
`docker-compose run --rm app bash`

Now you are in an interactive console that can has access to php

_You could also use `docker-compose run --rm app php artisan {command here}`_

