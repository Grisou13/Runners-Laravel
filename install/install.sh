#!/bin/bash
#bash -c 'BASH_ENV=/etc/profile exec bash'
if [ "$EUID" -ne 0 ]
  then echo "Please run as root"
  exit 2
fi
set -o history
set -H
##############################################################################
#repo data
REPO_URL="https://github.com/CPNV-ES/Runners-Laravel.git"
PROJECT_NAME="runners"
##############################################################################
echo "PWD: $(pwd -P)"
PATH_TO_SCRIPT=$(cd ${0%/*} && echo $PWD/${0##*/})
SCRIPT_DIR=`dirname "$PATH_TO_SCRIPT"`
echo "Directory: $SCRIPT_DIR"
# create log file
LOG="$SCRIPT_DIR/install.log"
echo "LOG PATH $LOG"
echo "" > $LOG #clears the log
chmod 666 $LOG &> /dev/null


apt-get update &>> $LOG
apt-get install -y python-software-properties software-properties-common curl wget &>> $LOG
if [ ! -f /var/www/.ppa_updated ]
then
  echo "Updating PPA"
  touch /var/www/.ppa_updated
  # node
  curl -sL https://deb.nodesource.com/setup_6.x | bash - &>> $LOG
  # php
  LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php &>> $LOG
  # redis
  add-apt-repository -y ppa:chris-lea/redis-server &>> $LOG
  # hhvm
  apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0x5a16e7281be7a449 &>> $LOG
  add-apt-repository "deb http://dl.hhvm.com/ubuntu $(lsb_release -sc) main" &>>$LOG
  # mariaDB
  apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xF1656F24C74CD1D8 &>>$LOG
  add-apt-repository 'deb [arch=amd64,i386,ppc64el] http://ftp.osuosl.org/pub/mariadb/repo/10.1/ubuntu xenial main' &>>$LOG

  apt-get update &>> $LOG

fi
# install misc packages
echo "Installing misc tools"
apt-get install -y dos2unix libssl-dev gcc tcl8.5 unzip vim git-core git pkg-config build-essential libyaml-dev mercurial &>> $LOG

# create variables
APP_KEY=$(openssl rand -base64 32)
MYSQL_ROOT_PWD="root"
MYSQL_USR_PWD=$(openssl rand -base64 12)
MYSQL_USER="runners"
MYSQL_DB="runner"

REPO_PATH="/var/www/$PROJECT_NAME"
mkdir -p $REPO_PATH &> /dev/null

SITE_PATH="$REPO_PATH/public"
SITE_NAME=$PROJECT_NAME

echo "Cloning repo \($REPO_URL\)"
if [ -f $REPO_PATH/.env ]; then
  cd $REPO_PATH
  git pull
  cd $OLDPWD
else
  git clone $REPO_URL $REPO_PATH
fi

if [ "$?" -ne 0 ]
  then echo "Something went wrong in cloning of repo"
  exit 2
fi


####################
# Install nginx
####################
if [ ! -f /etc/nginx/nginx.conf ]; then
  echo "Installing NGINX"
  apt-get install -y nginx &>> $LOG
fi
echo "Configuring nginx"
rm -f /etc/nginx/sites-enabled/* &>> $LOG
rm -f /etc/nginx/sites-available/* &>> $LOG

mkdir /etc/nginx/ssl 2>/dev/null

PATH_SSL="/etc/nginx/ssl"
PATH_KEY="${PATH_SSL}/runners.key"
PATH_CSR="${PATH_SSL}/runners.csr"
PATH_CRT="${PATH_SSL}/runners.crt"

# TODO add letsencrypt
# apt-get install letsencrypt &> /dev/null
# letsencrypt certonly --webroot -w /etc/nginx/ssl -d $SITE_NAME.app -d localhost -d $SITE_NAME
# cron="00 09,13 * * * root letsencrypt renew --dry-run --agree-tos >> /dev/null 2>&1"
# echo "$cron" > "/etc/cron.d/cert_update"


if [ ! -f $PATH_KEY ] || [ ! -f $PATH_CSR ] || [ ! -f $PATH_CRT ]
then
  echo "Generating SSL self signed certificate"
  openssl genrsa -out "$PATH_KEY" 2048 2>/dev/null
  openssl req -new -key "$PATH_KEY" -out "$PATH_CSR" -subj "/CN=app.$PROJECT_NAME/O=$PROJECT_NAME/C=CH" -config <(cat /etc/ssl/openssl.cnf \
        <(printf "[SAN]\nsubjectAltName=DNS:app.$PROJECT_NAME,DNS:www.$PROJECT_NAME.com,DNS:$PROJECT_NAME.com")) 2>/dev/null
  openssl x509 -req -days 365 -in "$PATH_CSR" -signkey "$PATH_KEY" -out "$PATH_CRT" 2>/dev/null
fi
block="server {
    listen 80;
    listen 443 ssl http2;
    server_name app.${SITE_NAME} *.${SITE_NAME}.com;
    root \"${SITE_PATH}\";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/${SITE_NAME}-error.log error;

    sendfile off;

    client_max_body_size 100m;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;

        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
    }

    location ~ /\.ht {
        deny all;
    }

    ssl_certificate     ${PATH_CRT};
    ssl_certificate_key ${PATH_KEY};
}
"

echo "$block" > "/etc/nginx/sites-available/$SITE_NAME"
ln -fs "/etc/nginx/sites-available/$SITE_NAME" "/etc/nginx/sites-enabled/$SITE_NAME"


############################
# PHP / PHP FPM
############################
mkdir /var/www &> /dev/null

if [ ! -d "/etc/php" ]; then
  echo "Installing php"
  sudo apt-get install -y php7.0 php7.0-cli php7.0-dev php7.0-mysql php7.0-mcrypt php7.0-json php7.0-fpm php7.0-xml php7.0-xsl php-imagick php7.0-curl php7.0-gd php7.0-intl &> $LOG

  sed -i \
           -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" \
           -e "s/upload_max_filesize\s*=\s*2M/upload_max_filesize = 100M/g" \
           -e "s/post_max_size\s*=\s*8M/post_max_size = 100M/g" \
           /etc/php/7.0/fpm/php.ini
  sed -i \
           -e "s/;catch_workers_output\s*=\s*yes/catch_workers_output = yes/g" \
           -e "s/pm.max_children = 5/pm.max_children = 4/g" \
           -e "s/pm.start_servers = 2/pm.start_servers = 3/g" \
           -e "s/pm.min_spare_servers = 1/pm.min_spare_servers = 2/g" \
           -e "s/pm.max_spare_servers = 3/pm.max_spare_servers = 4/g" \
           -e "s/;pm.max_requests = 500/pm.max_requests = 200/g" \
           /etc/php/7.0/fpm/php-fpm.conf
  sed -i \
          -e "s/;listen.mode = 0660/listen.mode = 0666/g" \
          /etc/php/7.0/fpm/pool.d/www.conf
          #  -e "s/user = www-data/user = nginx/g" \
          #  -e "s/group = www-data/group = nginx/g" \
          #  -e "s/;listen.mode = 0660/listen.mode = 0666/g" \
          #  -e "s/;listen.owner = www-data/listen.owner = nginx/g" \
          #  -e "s/;listen.group = www-data/listen.group = nginx/g" \
          #  /etc/php/7.0/fpm/pool.d/www.conf
fi

#composer
if [ ! -f /usr/bin/composer ]; then
  apt-cache show composer &> /dev/null
  if [ "$?" -ne 0 ]; then
    curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
  else
    apt-get install -y composer &>> $LOG
  fi

  cd $REPO_PATH
  composer install &>> $LOG
  cd $OLDPWD
fi

#########################
# Memchache
##########################

echo "Installing memcache"
apt-get install memcached libmemcached-dev -y &> /dev/null

if [ ! -f /etc/php/mods-available/memcached.ini ]; then
  echo "Installing memcache php extension from source... this might take a while"
  git clone https://github.com/php-memcached-dev/php-memcached.git &>> $LOG
  cd php-memcached
  git checkout php7 &>> $LOG
  phpize &>> $LOG
  ./configure --disable-memcached-sasl &>> $LOG
  make &>> $LOG
  make install &>> $LOG
  cd $OLDPWD

  rm -rf php-memcached &> /dev/null

  block="
; configuration for php memcached module
; priority=20
extension=memcached.so
  "
  mkdir /etc/php/mods-available/ &> /dev/null
  chmod 755 /etc/php/mods-available/ &> /dev/null
  echo "$block"> /etc/php/mods-available/memcached.ini
  rm -rf /etc/php/7.0/fpm/conf.d/20-memcached.ini &> /dev/null
  rm -rf /etc/php/7.0/cli/conf.d/20-memcached.ini &> /dev/null

  ln -s /etc/php/mods-available/memcached.ini /etc/php/7.0/fpm/conf.d/20-memcached.ini
  ln -s /etc/php/mods-available/memcached.ini /etc/php/7.0/cli/conf.d/20-memcached.ini
fi
##########################
# Mysql / MariaDB
##########################
echo "Installing mysql"

if [ ! -f /var/www/.maria ]
then

  touch /var/www/.maria

  # Remove MySQL

  apt-get remove -y --purge mysql-server mysql-client mysql-common &> /dev/null
  apt-get autoremove -y &> /dev/null
  apt-get autoclean &> /dev/null

  rm -rf /var/lib/mysql
  rm -rf /var/log/mysql
  rm -rf /etc/mysql


  # Set The Automated Root Password

  export DEBIAN_FRONTEND=noninteractive

  debconf-set-selections <<< "mariadb-server-10.1 mysql-server/data-dir select ''"
  debconf-set-selections <<< "mariadb-server-10.1 mysql-server/root_password password root"
  debconf-set-selections <<< "mariadb-server-10.1 mysql-server/root_password_again password root"

  # Install MariaDB

  apt-get install -y mariadb-server &>> $LOG

  # Configure Password Expiration

  echo "default_password_lifetime = 0" >> /etc/mysql/my.cnf

  # Configure Maria Remote Access

  sed -i '/^bind-address/s/bind-address.*=.*/bind-address = 0.0.0.0/' /etc/mysql/my.cnf

  mysql --user="root" --password="root" -e "GRANT ALL ON *.* TO root@'0.0.0.0' IDENTIFIED BY 'root' WITH GRANT OPTION;"
  service mysql restart &> /dev/null
  mysql --user="root" --password="root" -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DB;"

  mysql --user="root" --password="root" -e "CREATE USER '$MYSQL_USER'@'0.0.0.0' IDENTIFIED BY '$MYSQL_USR_PWD';"
  mysql --user="root" --password="root" -e "GRANT ALL ON *.* TO '$MYSQL_USER'@'0.0.0.0' IDENTIFIED BY '$MYSQL_USR_PWD' WITH GRANT OPTION;"
  mysql --user="root" --password="root" -e "GRANT ALL ON *.* TO '$MYSQL_USER'@'%' IDENTIFIED BY '$MYSQL_USR_PWD' WITH GRANT OPTION;"
  mysql --user="root" --password="root" -e "FLUSH PRIVILEGES;"
  service mysql restart &> /dev/null



  echo "
[client]
user = $MYSQL_USER
password = $MYSQL_USR_PWD
host = localhost
" >> ~/.my.cnf

  cat ~/.my.cnf > /root/.my.cnf

  #copy my.cnf
  cat ~/.my.cnf > /etc/skel/.my.cnf

fi

cd $SITE_PATH
php artisan migrate --seed &>> $LOG
cd $OLDPWD
#(./mysql.sh $MYSQL_ROOT_PWD $MYSQL_USER $MYSQL_USR_PWD)

######################
# Schedule
######################
if [ ! -f /etc/cron.d/$SITE_NAME ]
then
  mkdir /etc/cron.d 2>/dev/null
  cron="* * * * * root /usr/bin/php $REPO_PATH/artisan schedule:run >> /dev/null 2>&1"
  echo "$cron" > "/etc/cron.d/$SITE_NAME"
  chmod 755 /etc/cron.d/$SITE_NAME
fi
#######################
# Node js
######################

if [ ! -f /usr/bin/node ]; then
  echo "Installing Nodejs"
  apt-get install -y nodejs &> /dev/null
  curl -sL https://www.npmjs.com/install.sh | sh &>>$LOG

  echo "Installing node dependencies"

  npm install -g typescript &> /dev/null
  npm install -g gulp &> /dev/null
  npm install -g grunt &> /dev/null
fi

npm install -g yarn &> /dev/null
cd $REPO_PATH
yarn install &>>$LOG
cd $OLDPWD

##################
# REDIS
##################
if [ ! -f /usr/bin/redis-server ]; then
  echo "Installing redis"
  apt-get install -y redis-server &>> $LOG
fi
###########################
# DHCP
###########################
if [ ! -f /etc/dhcp/dhcpd.conf ]; then
  echo "Installing DHCP server"
  echo "manual" >/etc/init/isc-dhcp-server.override
  chmod 666 /etc/init/isc-dhcp-server.override
  apt-get install -y isc-dhcp-server &>> $LOG
  mkdir -p /etc/dhcp/ &> /dev/null
  echo '
ddns-update-style none;
log-facility local7;

subnet 192.168.1.0 netmask 255.255.255.0 {

        option routers                  192.168.1.1;
        option subnet-mask              255.255.255.0;
        option broadcast-address        192.168.1.255;
        option domain-name-servers      194.168.1.1;
        option ntp-servers              192.168.1.1;
        option netbios-name-servers     192.168.1.1;
        option netbios-node-type 2;
        default-lease-time 86400;
        max-lease-time 86400;

}
' > /etc/dhcp/dhcpd.conf
  echo '
INTERFACES="eth0"
' > /etc/default/isc-dhcp-server
fi
#################################
# DNS / Reverse DNS
#################################
if [ ! -d /etc/bind/ ]; then
  echo "Installing DNS server..."
  apt-get update --fix-missing &>> $LOG
  apt-get install -y bind9 bind9utils bind9-doc &>> $LOG
  # just in case, so the script doesn't fail too bad

  mkdir -P /etc/bind 2> /dev/null
  touch /etc/bind/for.$PROJECT_NAME
  touch /etc/bind/rev.$PROJECT_NAME
  echo '
include "/etc/bind/named.conf.options";
include "/etc/bind/named.conf.local";
include "/etc/bind/named.conf.default-zones";
' > /etc/bind/named.conf
  echo "
options {
        directory \"/var/cache/bind\";

        recursion yes;                 # enables resursive queries
        allow-recursion { trusted; };  # allows recursive queries from \"trusted\" clients
        listen-on { 192.168.1.1; };   # ns1 private IP address - listen on private network only
        allow-transfer { none; };      # disable zone transfers by default

        forwarders {
                172.17.10.5;
                8.8.8.8;
                8.8.4.4;
        };
};
" > /etc/bind/named.conf.options
  echo "
zone \"$PROJECT_NAME.dns\" {
        type master;
        file \"/etc/bind/for.$PROJECT_NAME\";
        allow-transfer {
          172.17.10.5;
          8.8.8.8;
        };
 };
zone \"1.168.192.in-addr.arpa\" {
        type master;
        file \"/etc/bind/rev.$PROJECT_NAME\";
        allow-transfer {
          172.17.10.5;
          8.8.8.8;
        };

 };
" > /etc/bind/named.conf.local

  echo '
OPTIONS="-4 -u bind"
'>/etc/default/bind9

  echo '
\$TTL 86400
@   IN  SOA     api.$PROJECT_NAME.com www.$PROJECT_NAME.com app.$PROJECT_NAME. pri.$PROJECT_NAME.dns. root.$PROJECT_NAME.dns. (
        2011071001  ;Serial
        3600        ;Refresh
        1800        ;Retry
        604800      ;Expire
        86400       ;Minimum TTL
)
@           IN  NS          pri.$PROJECT_NAME.dns.
@           IN  PTR          $PROJECT_NAME.dns.
@           IN  A          www.$PROJECT_NAME.com.
@           IN  A          $PROJECT_NAME.app.
@           IN  A          api.$PROJECT_NAME.com.
@           IN  A           192.168.1.1
app     IN  A       192.168.1.1
api     IN  A       192.168.1.1
'>/etc/bind/for.$PROJECT_NAME

  echo "
\$TTL 86400
@   IN  SOA     api.$PROJECT_NAME.com www.$PROJECT_NAME.com app.$PROJECT_NAME. pri.$PROJECT_NAME.dns. root.$PROJECT_NAME.dns. (
        2011071002  ;Serial
        3600        ;Refresh
        1800        ;Retry
        604800      ;Expire
        86400       ;Minimum TTL
)
@       IN  NS          pri.$PROJECT_NAME.dns.
@       IN  PTR         $PROJECT_NAME.dns.

1     IN  PTR         pri.$PROJECT_NAME.dns.
1     IN  PTR         app.$PROJECT_NAME.
1     IN  PTR         api.$PROJECT_NAME.com.
1     IN  PTR         www.$PROJECT_NAME.com.

">/etc/bind/rev.$PROJECT_NAME

  chmod -R 755 /etc/bind
  chown -R bind:bind /etc/bind
  #if dns fails just add it to hosts file
  echo "127.0.0.1    app.$PROJECT_NAME" >> /etc/hosts
  echo "127.0.0.1    api.$PROJECT_NAME" >> /etc/hosts
  echo "127.0.0.1    www.$PROJECT_NAME.com" >> /etc/hosts
  echo "127.0.0.1    $PROJECT_NAME.com" >> /etc/hosts
fi

#overide writes
chown -R :www-data $REPO_PATH &>> $LOG
# create .env
echo "Generating .env file"
env="
APP_ENV=staging
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_LOG_LEVEL=debug
APP_URL=http://localhost

API_PREFIX=api
API_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=${MYSQL_DB}
DB_USERNAME=${MYSQL_USER}
DB_PASSWORD=${MYSQL_USR_PWD}

BROADCAST_DRIVER=redis
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_KEY=
PUSHER_SECRET=
"
echo $env > $REPO_PATH/.env
######
# restart stuff
######
echo "Restarting nginx"
service nginx restart
echo "Restarting php-fpm"
service php7.0-fpm restart
echo "Restarting mysql"
service mysql restart
echo "Restarting DHCP"
service isc-dhcp-server restart
echo "Restarting DNS"
systemctl restart bind9
echo
echo "Everything went ok normaly. You can check the log file $LOG"
echo "Your project $PROJECT_NAME was installed in $REPO_PATH"
echo "You should be able to access it with http://$PROJECT_NAME.app or http://localhost"
echo "Redis was installed without any credentials"
echo "You can access your databases on port 3306 with 2 users : "
echo "username=>root"
echo "pwd=>$MYSQL_ROOT_PWD"
echo
echo "username=>$MYSQL_USER"
echo "pwd=>$MYSQL_USR_PWD"
echo
php -v
composer --version
nginx -v
redis-server --version
