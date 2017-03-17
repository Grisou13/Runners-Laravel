#!/bin/bash
#bash -c 'BASH_ENV=/etc/profile exec bash'
if [ "$EUID" -ne 0 ]
  then echo "Please run as root"
  exit 2
fi
set -o history
set -H

PROJECT_NAME="runners"

rm -rf /etc/cron.d/$PROJECT_NAME

apt-get remove --auto-remove  "mysql*" -y isc-dhcp-server "bind9*" mariadb-server redis-server nginx "php*" nodejs npm
apt-get purge --auto-remove "mysql*" -y isc-dhcp-server"bind9*" mariadb-server redis-server nginx "php*" nodejs npm

# php
rm -rf /var/www/$PROJECT_NAME &> /dev/null
rm -rf /usr/local/bin/composer
#nginx
rm -rf /etc/nginx/ssl/$PROJECT_NAME.* &> /dev/null
# mysql
rm -rf /var/www/.maria &> /dev/null
# dns
rm -rf /etc/bind/zones &> /dev/null
rm -rf /etc/default/bind9 &> /dev/null
#node and pm
rm -rf /usr/local/bin/npm /usr/local/share/man/man1/node* /usr/local/lib/dtrace/node.d ~/.npm ~/.node-gyp /opt/local/bin/node opt/local/include/node /opt/local/lib/node_modules &> /dev/null
rm -rf /usr/local/lib/node* &> /dev/null
rm -rf /usr/local/include/node* &> /dev/null
rm -rf /usr/local/bin/node* &> /dev/null
#dhcp config
rm -rf /etc/init/isc-dhcp-server.override &> /dev/null
rm -rf /etc/default/isc-dhcp-server &> /dev/null
