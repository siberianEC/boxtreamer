#!/bin/bash -l
#$ -S /bin/bash
#$ -N $2
unzip /var/www/upgrade.zip -d /var/www > /dev/null 2>&1
rm /var/www/upgrade.zip
var=$( cat /var/www/html_upgrade/app/core/security 2>/dev/null)
if [ "$var" == "37f268d2799cab0875367661cf1cb52682691842" ]; then
	rm -rf /var/www/html/
	mv /var/www/html_upgrade /var/www/html
	chmod -R 777  /var/www/
	echo "6"
else
	rm -rf /var/www/html_upgrade/
	echo "7"
fi