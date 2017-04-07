#!/bin/bash
###############################
# Network
##############################
# Configure network

echo "Renaming network interfaces..."
# Renaming interfaces to ethX
i=0
for interface in $(ifconfig -a | sed 's/[ \t].*//;/^\(lo\|\)$/d')
do
  echo "=> $interface to eth$i"
  ifconfig $interface down
  ip link set $interface name eth$i
  ifconfig eth$i up
  i=$((i+1))
done

echo "Overiding network interface"
cp /etc/network/interfaces /etc/network/interfaces.bak
cp ./config/interfaces /etc/network/interfaces

for interface in $(ifconfig -a | sed 's/[ \t].*//;/^\(lo\|\)$/d')
do
  ifconfig $interface down >> $LOG
  ifconfig $interface up >> $LOG
done

sleep 5
