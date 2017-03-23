#!/bin/bash
# Install laravel-echo-server
######################
npm install -g forever &> /dev/null
npm install -g laravel-echo-server &> /dev/null

mkdir -p /var/forever/pids
chmod 777 /var/forever/pids
echo "
#!/bin/sh
#/etc/init.d/laravelecho
export PATH=$PATH:/usr/local/bin
export NODE_PATH=$NODE_PATH:/usr/local/lib/node_modules
$BIN=/usr/local/lib/node_modules/laravel-echo-server/bin/server.js
case "$1" in
  start)
  exec forever -s -m 5 -p /var/forever/pids start  $BIN start
  ;;
stop)
  exec forever stop $BIN
  ;;
*)
  echo "Usage: /etc/init.d/laravelecho {start|stop}"
  exit 1
  ;;
esac
exit 0
" > /etc/init.d/laravelecho
chmod 755 /etc/init.d/laravelecho
update-rc.d laravelecho defaults


#############
# Mails
###########
apt install -y golang-go &>> /dev/null
export GOPATH=$HOME/go
export PATH=$PATH:$GOROOT/bin:$GOPATH/bin
echo "export GOPATH=$HOME/go" > /etc/profile.d/go.sh
echo "export PATH=$PATH:$GOROOT/bin:$GOPATH/bin" >> /etc/profile.d/go.sh
chmod 755 /etc/profile.d/go.sh

go get github.com/mailhog/MailHog &> /dev/null
chown :nobody $GOPATH/bin/MailHog
chmod 777 $GOPATH/bin/MailHog

echo "
#! /bin/sh
# /etc/init.d/mailhog
#
# MailHog init script.
#
# @author Jeff Geerling
### BEGIN INIT INFO
# Provides:          mailhog
# Required-Start:    $remote_fs $syslog
# Required-Stop:     $remote_fs $syslog
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: Start MailHog at boot time.
# Description:       Enable MailHog.
### END INIT INFO
PID=/var/run/mailhog.pid
LOCK=/var/lock/mailhog.lock
USER=nobody
BIN=$GOPATH/bin/MailHog
DAEMONIZE_BIN=start-stop-deamon
# Carry out specific functions when asked to by the system
case "$1" in
  start)
    echo \"Starting mailhog.\"
    $DAEMONIZE_BIN -p $PID -l $LOCK -u $USER $BIN
    ;;
  stop)
    if [ -f $PID ]; then
      echo \"Stopping mailhog.\";
      kill -TERM $(cat $PID);
      rm -f $PID;
    else
      echo \"MailHog is not running.\";
    fi
    ;;
  restart)
    echo \"Restarting mailhog.\"
    if [ -f $PID ]; then
      kill -TERM $(cat $PID);
      rm -f $PID;
    fi
    $DAEMONIZE_BIN -p $PID -l $LOCK -u $USER $BIN
    ;;
  status)
    if [ -f $PID ]; then
      echo \"MailHog is running.\";
    else
      echo \"MailHog is not running.\";
      exit 3
    fi
    ;;
  *)
    echo \"Usage: /etc/init.d/mailhog {start|stop|status|restart}\"
    exit 1
    ;;
esac
" > /etc/init.d/mailhog
chmod 755 /etc/init.d/mailhog
update-rc.d mailhog defaults