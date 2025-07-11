#!/bin/bash

# Load environment variables from the .env file
while IFS='=' read -r key value; do
  if [[ -z "${!key}" && "$key" != \#* && -n "$key" ]]; then
    export "$key=$value"
  fi
done < .env

# Run your SQL script every time
echo "Running db_export.sql : import data to database ${DB_DATABASE}..."

mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASSWORD" -P "$DB_PORT" "$DB_DATABASE" < "${PWD}/database/sql/db_export.sql"

# Call original entrypoint command
exec "$@"
