#!/bin/bash

# Run your SQL script every time
echo "Running db_export.sql..."

mysql -h mysql -u root -ppassword laravel < /sql/db_export.sql

# Call original entrypoint command
exec "$@"
