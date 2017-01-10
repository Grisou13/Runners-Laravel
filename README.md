# PRW02 - Runners
## Installation
### Server requirements
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Fast developpement setup

First install [sqlite](https://sqlite.org/download.html).

Then change the .env with
```
DB_CONNECTION=sqlite
```

To get a local developpement server, you can use the following command :
```
php arstisan migrate --seed
php artisan serve
```

The server should now be accessible on `http://localhost:8000`.

And install [composer](https://getcomposer.org/download/) if not already done.
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '55d6ead61b29c7bdee5cccfb50076874187bd9f21f65d8991d46ec5cc90518f447387fb9f76ebae1fbbacf329e583e30') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

### Laravel setup
```
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
```
To get more specifications use the [laravel documentation](https://laravel.com/docs/5.3/installation).
