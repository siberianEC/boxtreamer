#!/bin/bash -l
#$ -S /bin/bash
#$ -N $2
pkill play
sleep 1
amixer set PCM $1%
sudo rm /var/www/html/music.log
play -t mp3 $2 $3 $4 > /var/www/html/music.log 2>&1

