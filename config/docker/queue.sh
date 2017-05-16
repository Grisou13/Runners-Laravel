#!/bin/bash

# Defaults to an app server
role=${CONTAINER_ROLE:-schedule}

echo "Container role: $role"

if [ "$role" = "queue" ]; then
    # Run queue
    while [ true ]
    do
      php /var/www/artisan queue:work --verbose --tries=3 --timeout=9000
    done
elif [ "$role" = "schedule" ]; then
    while [ true ]
    do
      php /var/www/artisan schedule:run --verbose --no-interaction
      sleep 60
    done
else
    echo "Could not match the container role...."
    exit 1
fi