#!/bin/bash
while true
do
	echo "Press [CTRL+C] to stop.."
	sleep 10
	php artisan queue:work
done
