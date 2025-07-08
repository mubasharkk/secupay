#!/bin/bash

# Run your SQL script every time
echo "Running db_export.sql..."

mysql -h "$DB_HOST" -u "$DB_USER" -P "$DB_PORT" "$DB_DATABASE" < "${PWD}/database/sql/db_export.sql"

# Call original entrypoint command
exec "$@"
