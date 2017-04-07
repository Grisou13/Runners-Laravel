#!/bin/bash
# domaine : CPNV-SC

MYIP=`hostname -I | awk '{ print $1}'`
echo -e "server 172.17.10.5\nupdate delete "$HOSTNAME".sc.cpnv.ch 3600\nsend\n" | nsupdate -v
echo -e "server 172.17.10.5\nupdate add "$HOSTNAME".sc.cpnv.ch 3600 A "$MYIP"\nsend\n" | nsupdate -v

read -p "OK CALM DOWN, DROP YOUR GUN AND GIVE ME YOUR USERNAME : " login;
smbclient -L //sc-file-sv06/commun -U $login -W cpnv.ch
