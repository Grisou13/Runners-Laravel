#!/bin/bash
echo "Installing composer"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
SIG=$(wget -q -O - https://composer.github.io/installer.sig)
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$SIG') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php &>> $LOG
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer
/usr/local/bin/composer self-update &> /dev/null
export PATH=$PATH:$HOME/.composer/vendor/bin
echo "export PATH='$PATH:$HOME/.composer/vendor/bin'" > /etc/profile.d/composer.sh
chmod 755 /etc/profile.d/composer.sh
