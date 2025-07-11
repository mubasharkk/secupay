#!/bin/bash

# Load environment variables from the .env file
if [ -f ".env" ]; then
    echo "Loading environment variables from .env file..."

    # Read each line in the .env file
    while IFS='=' read -r key value || [ -n "$key" ]; do
        # Skip comments and empty lines
        [[ "$key" =~ ^#.*$ || -z "$key" ]] && continue

        # Remove possible surrounding quotes and whitespace
        key=$(echo "$key" | xargs)
        value=$(echo "$value" | sed -e 's/^["'\''"]//' -e 's/["'\''"]$//' | xargs)

        # Only export if variable is not already set
        if [ -z "${!key}" ]; then
            export "$key=$value"
        fi
    done < .env

else
    echo ".env file not found!"
    exit 1
fi


# Run your SQL script every time
echo "Running db_export.sql : import data to database ${DB_DATABASE}..."

mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASSWORD" -P "$DB_PORT" "$DB_DATABASE" < "${PWD}/database/sql/db_export.sql"

# Call original entrypoint command
exec "$@"
