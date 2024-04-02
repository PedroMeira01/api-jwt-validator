#!/bin/bash

cd /var/www/html/
composer install
exec apache2ctl -D FOREGROUND
