#!/bin/bash

# Load environment variables from the .env file
if [ -f ".env" ]; then
    echo "Loading environment variables from .env file..."
    source .env
else
    echo ".env file not found!"
    exit 1
fi

# Run your SQL script every time
echo "Running db_export.sql..."

mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASSWORD" -P "$DB_PORT" "$DB_DATABASE" < "${PWD}/database/sql/db_export.sql"

# Call original entrypoint command
exec "$@"
