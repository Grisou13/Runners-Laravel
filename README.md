# PRW02 - Runners

## installation

Please refer to the documentation @ [doc/install.md](doc/install.md)

# Using the app

## Logins

If you seeded the database, you will hae a couple users, but a few are important.


| username | email          | password | access token |
|----------|----------------|----------|--------------|
| root     | root.toor@paleo.ch | root     | root         |

To access the app, please visit the url ```/home```.This page will give you access to all components of the app (it will require you to log in).

To access the api, please visit the url ```/api```. This page will display information necessary for you to use the api.

## Api

The brief documentation of the api, for now is available in the file [api.md](/api.md)

# Using the app with docker

If you choose to use docker, you can interact with the app using the following command

`docker-compose run --rm app /bin/bash`

After that, you should have access to artisan.

# Laravel-echo

PHP was not made for real time, this is why we need a nodejs utility server to do so.
Laravel provides a client javascript `laravel-echo` lib, but this doesn't manage notifications server side whise.
For this, we use `laravel-echo-server`.

This server/utility will listen to redis events, and transmit them via websocket.
This is why you need redis, to run laravel-echo-server with laravel.

Laravel-echo-server allows Laravel to send events to a javascript client. In our case, we use it for updating the run list in real time.
