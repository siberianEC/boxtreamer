#!/bin/bash -l
#$ -S /bin/bash
#$ -N $2
sudo rm /etc/netplan/00-installer-config.yaml
sudo touch /etc/netplan/00-installer-config.yaml
sudo chmod 755 /etc/netplan/00-installer-config.yaml
cambios="
# data de ejemplo\n
network:\n
\x20 version: 2\n
\x20 ethernets:\n
\x20\x20 enp2s0:\n
\x20\x20\x20 dhcp4: false\n
\x20\x20\x20 addresses: [$2]\n
\x20\x20\x20 nameservers:\n
\x20\x20\x20\x20 addresses: [8.8.8.8, 8.8.4.4]\n
\x20\x20\x20 routes:\n
\x20\x20\x20\x20 - to: default\n
\x20\x20\x20\x20\x20\x20 via: $3\n
"
echo -e $cambios > /etc/netplan/00-installer-config.yaml
sudo netplan apply
