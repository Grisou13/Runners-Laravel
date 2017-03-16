#!/bin/bash
# Check If Maria Has Been Installed

if [ -f /var/www/.maria ]
then
    echo "MariaDB already installed."
    exit 2;
fi

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
debconf-set-selections <<< "mariadb-server-10.1 mysql-server/root_password password $1"
debconf-set-selections <<< "mariadb-server-10.1 mysql-server/root_password_again password $1"

# Install MariaDB

apt-get install -y mariadb-server

# Configure Password Expiration

echo "default_password_lifetime = 0" >> /etc/mysql/my.cnf

# Configure Maria Remote Access

sed -i '/^bind-address/s/bind-address.*=.*/bind-address = 0.0.0.0/' /etc/mysql/my.cnf

mysql --user="root" --password="secret" -e "GRANT ALL ON *.* TO root@'0.0.0.0' IDENTIFIED BY '$1' WITH GRANT OPTION;"
service mysql restart

mysql --user="root" --password="secret" -e "CREATE USER '$2'@'0.0.0.0' IDENTIFIED BY '$3';"
mysql --user="root" --password="secret" -e "GRANT ALL ON *.* TO '$2'@'0.0.0.0' IDENTIFIED BY '$3' WITH GRANT OPTION;"
mysql --user="root" --password="secret" -e "GRANT ALL ON *.* TO '$2'@'%' IDENTIFIED BY '$3' WITH GRANT OPTION;"
mysql --user="root" --password="secret" -e "FLUSH PRIVILEGES;"
service mysql restart

cat > ~/.my.cnf << EOF
[client]
user = $2
password = $3
host = localhost
EOF
