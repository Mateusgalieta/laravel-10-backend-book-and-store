#!/bin/sh
set -e

if ! test -f /var/www/html/.env; then
    cp /var/www/html/.env.example /var/www/html/.env &&
    php artisan key:generate
fi

composer install &&

php artisan migrate --seed

if [ $(cd .. && ls -l | awk '{ print $4 }') != 'www-data' ]
then
    chown -Rf $USER:www-data /var/www/html
    chmod 775 /var/www/html/bootstrap /var/www/html/storage -Rf
    chown -R $USER:www-data /var/www/html
    chmod 775 /var/www/html -Rf
fi

cd /var/www/html/.docker/githooks && ls | xargs chmod +x && cd /var/www/html/.git/hooks && find ../../.docker/githooks -type f -exec ln -sf {} /var/www/html/.git/hooks/ \;

exec "$@"
