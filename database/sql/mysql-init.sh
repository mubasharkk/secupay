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

# Build password option only if DB_PASSWORD is not empty
if [ -n "$DB_PASSWORD" ]; then
    MYSQL_PWD_OPT="-p$DB_PASSWORD"
else
    MYSQL_PWD_OPT=""
fi

mysql -h "$DB_HOST" -u "$DB_USER" $MYSQL_PWD_OPT -P "$DB_PORT" "$DB_DATABASE" < "${PWD}/database/sql/db_export.sql"

#!/bin/bash

DB_CHECK=$(mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASSWORD" -P "$DB_PORT" -D "$DB_DATABASE" -N -s -e "
    SELECT table_name
    FROM information_schema.tables
    WHERE table_schema = '$DB_DATABASE'
    AND table_name IN ('api_apikey', 'transaktion_transaktionen', 'stamd_flagbit_ref', 'vorgaben_zeitraum');
")

# Convert output to array
readarray -t tables <<< "$DB_CHECK"

# Check for each table
for t in "api_apikey" "transaktion_transaktionen" "vorgaben_zeitraum" "stamd_flagbit_ref"; do
    if [[ " ${tables[*]} " == *" $t "* ]]; then
        echo "Table '$t' exists."
    else
        echo "Table '$t' does not exist."
    fi
done


# Call original entrypoint command
exec "$@"
