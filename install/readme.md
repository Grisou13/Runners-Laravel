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
- Dhcp server
- Dns server

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

# Post install

The DHCP and DNS server will not run if your interfaces aren't `èthx` (dhcp is bound by default to eth0). 
To change this, you need to lookup which interface you need to bind them on `ifconfig -a`.
Then edit the files `/etc/default/isc-dhcp-server`.
And change the `INTERFACE` section to what suites you.

After that you will need to put that interface in static IP.
For that edit the file `/etc/network/interfaces`

and add a section
```
auto eth0
iface eth0 inet static
    address 192.168.1.1
    netmask 255.255.255.0
```

You may change eth0 to the interface you just bounded to the dhcp service.
If this file already contains a section with eth0, just comment it out.

Then you need to restart your interfaces to apply the static ip `sudo ifdown eth0 && sudo ifup eth0` (where eth0 is your interface).

then restart the service `sudo service isc-dhcp-server restart`
and restart dns service `sudo service bind9 restart`

Error handling of the DHCP service is beyond the scope of this readme.
To troubleshoot anything, the installed service is named `isc-dhcp-server`.

# DHCP

The dhcp server will not run on startup of the machine. You need to force it to run
`sudo service isc-dhcp-server start`

Or if you want it to start by default just delete the file `/etc/init/isc-dhcp-server.override`
```
rm -rf /etc/init/isc-dhcp-server.override
```

# DNS

The DNS is bound to 192.168.1.1

Error handling of the DNS service is beyond the scope of this readme.
To troubleshoot anything, the installed service is named `bind9`.
