# Small install script 
This script will install everything you need for a fresh laravel.

Installed : 
- Nginx
- PHP7.0
    - composer
    - phpunit
    - php-fpm
- MariaDB (mysql)
- Redis
- Memcached

# Usage

```bash
curl -sL https://raw.githubusercontent.com/CPNV-ES/Runners-Laravel/feature/api-run-sub/install/install.sh
chmod 777 install.sh
nano install.sh
sudo ./install.sh
```
**!!Before executing the script you will need to complete some info!!**

You need to change 2 variables (they are at the top of the file):
- `REPO_URL`
- `PROJECT_NAME`

By changing these 2 variables you will now be able to clone any other repo that is *public*!
Or if you use github and want a private repo, you can use their `Presonal Access Token`.

This script will install your project in `/var/www/$PROJECT_NAME`

The script will create a database called `$PROJECT_NAME`.
If you need credentials you may look at your .env file
