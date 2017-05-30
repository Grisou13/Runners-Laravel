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

# With docker

First get yourself a fresh copy of docker, with docker-compose >= 1.8 (we need api v2).

Then

1. sudo docker-compose up -d
2. sudo docker-compose run --rm app php artisan key:generate

If nothing is written to your .env file (`$ cat .env`). You can rereun the command and copy the key and insert it manually in the file
`$ nano .env`

If you need to change anything in the env variables, like emails or what not, just be sure they aren't already set in `config/docker/app.env`.
Otherwise you might change the .env without affecting anything really.
Or you could just change it directly in the config files.

## Docker-machine

If you are running docker on windows or mac, you will probably be running docker-machine. If that is the case, you need to put the porject folder in your personnal directory!
This means cloning the project in ~/

# Normal install

1. Install some webserver (nginx prefabaly)
2. Install php >= 7.0.4
3. Install an sql database engine (mysql, or mariadb will do just fine)
4. Install the php drivers for mysql-pdo (just enable them in php.ini)
5. Install node.js [here](https://nodejs.org)
6. Install redis, and start a redis server [here](https://redis.io)
7. Run `$ npm i -g laravel-echo-server`

Now you have all the tools installed, you should configure your .env file to suite all your needs.

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

# With a vm

You can just redo the steps wither with docker, or the normal install.

# With Homestead

With homestead all you need is to add your site to your Homestead.yaml.

Don't forget to add the `schedule: true`