# SecuPay Task

[![Laravel Secupay Application (Mysql)](https://github.com/mubasharkk/secupay/actions/workflows/laravel.yml/badge.svg)](https://github.com/mubasharkk/secupay/actions/workflows/laravel.yml)

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
./vendor/bin/sail shell ./database/sql/mysql-init.sh
```

## Related Files 

Got it, Mubashar. Here’s a clean, developer-friendly section you can paste into your `README.md` to:

* Show relevant files involved in the API relationships
* Give a short description of each
* Provide **GitHub links** using the relative paths (which GitHub automatically resolves)
* Include test files for clarity

---

### 📁 Relevant Files and Responsibilities

#### Controllers

* [`App\Http\Controllers\Api`](app/Http/Controllers/Api)
  Contains API controllers that expose endpoints for accessing `contract`, `transaction`, etc.

#### Models

* [`App\Models`](app/Models)
  Eloquent models representing the database entities like `apiKey`, `zeitraum`, `contract`, `transaction`, `flagbit`, etc.

#### Services

* [`App\Services\DomainService.php`](app/Services/DomainService.php)
  Contains domain logic for associating or transforming domain data between models.

* [`App\Services\AuthenticatorService.php`](app/Services/AuthenticatorService.php)
  Handles authentication logic, typically working with `apiKey` or tokens.

---

### 🧪 Test Files

* [`tests/Unit`](tests/Unit)
  Unit tests validating the behavior of models, services, and helper logic. Useful for verifying relationship integrity and service logic.

---
## API Documentation

<details open>

<summary>View Details</summary>

---

### 📘 API Endpoint Summary

| Method | Endpoint                  | Description                     | Auth | Params / Notes                                                                                |
| ------ | ------------------------- | ------------------------------- | ---- |-----------------------------------------------------------------------------------------------|
| GET    | `/api/server-time`        | Get current server time         |     | –                                                                                             |
| GET    | `/api/flagbits`           | List all flagbits               | ✅    | –                                                                                             |
| GET    | `/api/flagbits/{trans_id}` | Get flagbit by transaction ID   | ✅    | `trans_id` in URL                                                                             |
| DELETE | `/api/flagbits/{trans_id}` | Delete flagbit from transaction | ✅    | `trans_id` in URL                                                                             |
| PUT    | `/api/flagbits` | Update/create flagbit           | ✅    | Body:  `datensatz_typ_id`, `datensatz_id (ie. trans_id)`, `flagbit`, `modus`, `bearbeiter_id` |
| GET    | `/api/transactions`       | List all transactions           | ✅    | –                                                                                             |

---

### 🔐 Authentication

* All endpoints require a **Bearer Token**.
* Header:
  `Authorization: Bearer YOUR_API_TOKEN`

---

### ❌ Error Response (401 Unauthorized)

```json
{
  "error": "Invalid API key provided."
}
```

---

</details open>

## Relationships 

<details> 
<summary>Following is a representation how I have understood that database structure</summary> 

```scss
apiKey
├── zeitraum (via zeitraum_id)
└── vertrag (via vertrag_id)
    └── Nutzer (via vertrag_id)
    └── transaktion (via vertrag_id)
        └── stamd_flagbit_ref
            └── flagbit (via flagbit_id)
            └── vorgaben_datensatz_typ (via datensatz_typ_id)
                └── (datensatz_typ_id = 2)
```
</details>
