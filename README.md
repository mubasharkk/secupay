# SecuPay Task

### Setup

---

### Install dependencies 

```shell
composer install
```

Copy `.env.example` to `.env`
```shell 
cp .env.example .env
```

To avoid PORT(s) conflicts, please update the following .env variables accordingly.

```shell
#whatever suits your machine bettern
APP_PORT=90

FORWARD_DB_PORT=3308
```

The container setup is already added using Laravel/Sail.

```shell
./vendor/bin/sail up -d

# or

docker compose up -d
```


For ease, I have already added these values as default.

#### Generate Laravel application key (if not generated)

```shell
./vendor/bin/sail artisan key:generate
```

#### Setup database

Import provided database by Secupay

```shell
./vendor/bin/sail shell /sql/mysql-init.sh
```
