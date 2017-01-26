# PRW02 - Runners
## Installation
### Server requirements
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Setup

**Make sure you have PHP in you PATH**

First, you will need to install [composer](https://getcomposer.org/download/) if not already done.
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '55d6ead61b29c7bdee5cccfb50076874187bd9f21f65d8991d46ec5cc90518f447387fb9f76ebae1fbbacf329e583e30') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```


To get a local developpement server, you can use the following command :
```
composer install
cp .env.example .env
php artisan key:generate

```
You'll need a mysql server. Modify your .env to adapt to your Mysql installation
```
DB_USERNAME=YOURUSERNAME
DB_PASSWORD=YOURUSERNAMEPASSWORD
```
Then you will either need to create, and or provide an empty database name in the .env
```
DB_DATABASE=THEDATABASENAME
```

Then execute the following command to create and populate your databse with dummy data.
```
php artisan migrate --seed
```
This will create the database tables **AND** populate the database with Dummy Data.
The dummy data includes a default login for the system.

Then execute ```php artisan serve ```. This command will launch a PHP developpment server accessible on `http://localhost:8000`.

If you are stuck during the installation, please visit the [laravel documentation](https://laravel.com/docs/5.3/installation), or create an [issue](https://github.com/CPNV-ES/Runners-Laravel/issues/new).

### Default User

The default user will allow you to access anything within the app. From basic login, to the api.

| username | email          | password | access token |
|----------|----------------|----------|--------------|
| root     | root@localhost | root     | root         |

To access the app, please visit the url ```/home```.This page will give you access to all components of the app (it will require you to log in).

To access the api, please visit the url ```/api```. This page will display information necessary for you to use the api.

### Api

The brief documentation of the api, for now is available in the file [api.md](/api.md)

### Participants

Please refer to "PARTICIPANTS.md" to know which part each student devolopped.
