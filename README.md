# PRW02 - Runners
## Server requirements
Please make sure your envirronement has the following:
- PHP >= 5.6.4
    - OpenSSL PHP Extension
    - PDO PHP Extension
    - Mbstring PHP Extension
    - Tokenizer PHP Extension
    - XML PHP Extension
- Web server
- Redis
- Node >= 7.10.0
- Docker-compose >= 1.8

## Installation


If you have some trouble please visit the [laravel documentation](https://laravel.com/docs/5.3/installation), or create an [issue](https://github.com/CPNV-ES/Runners-Laravel/issues/new).

The preferred way is using docker-compose (The installation of docker-compose is beyond the scope of this tutorial).

`docker-compose up -d`

And then visit localhost:8080.

*If the port is already occupied, you can edit `docker-compose.yaml` and change the `ports` under the `web` service to something that suits you better.*

*If you are using a mac, or windows, we recommend you use [vagrant with Homestead](https://laravel.com/docs/5.4/homestead)*
*Or maybe a vm with docker installed*

*note. If you are using docker, you can skip completly this step*

First Install [composer](https://getcomposer.org/download/).

### Install the app
First off, either clone the repo, or pull it

```
git clone https://github.com/CPNV-ES/Runners-Laravel.git
```

Then you will need to install dependencies.
```
composer install
cp .env.example .env
php artisan key:generate
```

### setup .env
Now you need to change your .env to suit your needs (mainly database stuff related)
```
DB_USERNAME=YOURUSERNAME
DB_PASSWORD=YOURUSERNAMEPASSWORD
DB_DATABASE=THEDATABASENAME
```
The default database is mysql, if you don't have mysql, you can use sqlite
```
DB_CONNECTION=sqlite
DB_DATABASE=database/db.sqlite
```
And then create the file `touch database/db.sqlite`

### setup database
Then execute the following command to create and populate your databse with dummy data.
```
php artisan migrate --seed
```
This will create the database tables **AND** populate the database with Dummy Data.
The dummy data includes a default login for the system.

*If you are having trouble with migrations*
`php artisan db:reset`

### install dependencies
The only big dependency this app has is laravel-echo-server.
If you are wondering what is laravel-echo-server , please read [Laravel-echo](Laravel-echo)

To install laravel-echo-server.
`sudo npm i -g laravel-echo-server`

Goto config/broadcasting
`cd config/broadcasting`

And edit the laravel-echo-server.json config file and adapt the `redis` section
``` 
nano laravel-echo-server.json
...
"databaseConfig": {
		"redis": {
		    "host":"url/ip of redis host(localhost)",
		    "port:"6379"
		},
		"sqlite": {
			"databasePath": "./../../database/laravel-echo-server.sqlite"
		}
	}
....
```

Now you can start laravel-echo-server `laravel-echo-server start`

**The laravel-echo-server process MUST always run for the app to add realtime**

# Using the app

## Logins

If you seeded the database, you will hae a couple users, but a few are important.


| username | email          | password | access token |
|----------|----------------|----------|--------------|
| root     | root@localhost | root     | root         |

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