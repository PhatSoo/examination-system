# Examination System API

## Table of Contents

-   `docker compose up -d`
-   `php artisan migrate`
-   `php artisan passport:client --personal`

## Getting Started

> # REST API for Examination System

### Requirements

```
PHP >= 8.0
Laravel >= 11.x
MySQL (Docker)
```

### Installation

#### 1. Clone the repository:

```bash
git clone https://github.com/PhatSoo/examiation-system

cd backend
```

#### 2. Install dependencies:

```bash
composer install
```

#### 3. Configure environment variables:

```bash
cp .env.example .env
```

Update .env with your database credentials and other environment-specific settings.

#### 4. Run docker for Mysql _(optional)_:

```bash
docker compose up -d
```

#### 5. Run migrations & Create client:

```bash
php artisan migrate --seed

php artisan passport:client --personal
```

#### 6. Run the server:

```bash
php artisan serve
```

## Creating new Account

<details>
    <summary><code>POST</code> <code><b>/</b></code> <code>(create new account)</code></summary>

### Parameters

> | name                 | type     | data type    | description         |
> | -------------------- | -------- | ------------ | ------------------- |
> | `email`              | required | string,email | email for login     |
> | `name`               | required | string       | user name           |
> | `role_id`            | optional | number       | user role           |
> | `password`           | required | string       | password            |
> | `password_confirmed` | required | string       | compare to password |

### Responses

> | code  | response                  |
> | ----- | ------------------------- |
> | `201` | `Create new User success` |
> | `400` | `Email has been taken`    |
> | `500` | `Internal server error`   |

### Example URL

> ```bash
> http://localhost:8000/api/v1/register
> ```

</details>
