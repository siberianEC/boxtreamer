#!/bin/bash
file=/var/www/html/.process_count
number=$(<"$file")

number_new=$(top -b -n 1 | grep play | tail -1 | head -2 | awk '{print $11}')
pid=$(top -b -n 1 | grep play | tail -1 | head -2 | awk '{print $1}')

if [ "$number_new" = "$number" ];then
kill -9 $pid
echo "se murio :("
else
echo "todo ok"
fi


echo "Hola el numero es -> $number"
echo $number_new > "$file"
