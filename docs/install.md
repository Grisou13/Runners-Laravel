# Server requirements

- PHP >= 7.0.4
    - OpenSSL PHP Extension
    - PDO PHP Extension
    - Mbstring PHP Extension
    - Tokenizer PHP Extension
    - XML PHP Extension
- Webserver (nginx or apache)
- Mysql >= 13.04
- Composer
- Node >= 7.0.0

# Installing

First you will need a fresh copy of the project, and a terminal.
```
$ git clone https://github.com/CPNV-ES/Runners-Laravel runners
$ cd runners
$ sudo chmod -R 777 storage
$ sudo chmod -R 777 bootstrap
$ cp .env.example .env
```
Now you have the choice, either to work with docker, a vm, vagrant, or homestead.

__Please make sure you check [Post install operations](Post install operations)__

# With docker

First get yourself a fresh copy of docker, with docker-compose **>= 1.8** (we need api v2).

Run the following:
1. `sudo docker-compose up -d`
2. `sudo docker-compose run --rm app php artisan key:generate`

Then run `artisan key:generate`
If nothing is written to your .env file (`$ cat .env`), you can re-run the command and copy the key and insert it manually in the file with `$ nano .env`


Since PHP Dotenv doesn't override by default already environment variables, please check `config/docker/app.env`, if you need to change anything.
All variables that aren't set in that file, can be set via your `.env` file.
For more examples look at `.env.example`.
Or you could specify them in your config files, instead of `.env`.

## Docker-machine

If you are running docker on windows or mac, you will probably be running docker-machine. If that is the case, you need to put the porject folder in your personnal directory!
This means cloning the project in ~/

# Normal install

## Prerequisites

[please refer to server requirements](#Server requirements)

## Install
Edit the .env file to suit your needs, database wise atleast.

And let's get started
```
# install dependencies
$ composer install
$ php artisan key:generate
# asset compiler
$ npm i -g gulp
# install deps
$ npm i
$ php artisan db:reset --production
```




# With a vm

You can just redo the steps wither with docker, or the normal install.

# With Homestead

With homestead all you need is to add your site to your Homestead.yaml.
For more information please check [the official documentation for homestead](https://laravel.com/docs/5.4/homestead#configuring-homestead)

After configuring, please add
`schedule: true`
To your sites config. [FYI](https://laravel.com/docs/5.4/homestead#configuring-cron-schedules)

# Post install operations

Now that the app is installed you will need to execute the following commands:

```
$ php artisan migrate
$ php artisan db:seed --class=BaseSeeder
$ sudo chmod 777 -R vendor/mpdf/mpdf/tmp
$ sudo chmod 777 -R vendor/mpdf/mpdf/graph_cache
$ sudo chmod 777 -R vendor/mpdf/mpdf/ttfontdata
```

If you have any problems with the seeding, or the database is giving you a hard time, a command was created
`php artisan db:reset`.
If supplied the argument `--production`, a seeder with real production data will be called.

_If you are using docker, run the commands above prefixed with `docker-compose run --rm app {command}`_

# Install laravel echo

## Prerequisites

- Redis [for more info on how to install redis]((https://redis.io/download))
- Node >= 7.0.0

## Install

``` 
$ npm i -g laravel-echo-server
```

Make sure redis is running, and that you have already changed the `.env` to suit your needs.

Now edit the `.env` and change 
```
...
BROADCAST_DRIVER=redis
QUEUE_DRIVER=redis
....
```

Now you will need to start a few deamons:
1. Start a redis-server instance
    `$ sudo service redis-server start`
2. start laravel-echo-server as a deamon or just as bacjground process
   `$ cd config/broadcasting/ && laravel-echo-server start`

3. Start a queue worker
   `$ php artisan queue:work --verbose`

4. Start a scheduler
    `$ sudo crontab -e`
    Add this to your crontab
    `* * * * * php /PATH TO YOUR PROJECT/artisan schedule:run >> /dev/null 2>&1`

Now you should be good to go.