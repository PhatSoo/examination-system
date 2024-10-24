# Examination System API

## Table of Contents

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

-   _Generate Laravel App Key_

```bash
php artisan key:generate
```

-   _Generate Passport Key_

```bash
php artisan passport:keys
```

-   _Run Migration_

```bash
php artisan migrate --seed
```

-   _Create Client Key to use Passport_

```bash
php artisan passport:client --personal
```

#### 6. Run the server:

```bash
php artisan serve
```

<br>

---

# LIST ENDPOINTS

> Base URL: **http://localhost:8000/api/v1**

## 1. Authentication

-   ### Prefix: `/`

| Method | Endpoint    | Description       |
| ------ | ----------- | ----------------- |
| `POST` | `/login`    | Login to system   |
| `POST` | `/register` | Create an account |
| `POST` | `/logout`   | Logout to system  |
| `GET`  | `/profile`  | Get user info     |

## 2. Role

-   ### Prefix: `/role`

| Method | Endpoint               | Description                         |
| ------ | ---------------------- | ----------------------------------- |
| `GET`  | `/`                    | Retrieve all `Role`                 |
| `GET`  | `/{id}`                | `Role` detail                       |
| `POST` | `/add-permission/{id}` | Add or Remove Permission for `Role` |

## 3. Permission

-   ### Prefix: `/permission`

| Method | Endpoint | Description               |
| ------ | -------- | ------------------------- |
| `GET`  | `/`      | Retrieve all `Permission` |
| `GET`  | `/{id}`  | `Permission` detail       |

## 4. Category

-   ### Prefix: `/category`

| Method   | Endpoint              | Description                             |
| -------- | --------------------- | --------------------------------------- |
| `GET`    | `/`                   | Retrieve all `Category`                 |
| `GET`    | `/{id}`               | `Category` detail                       |
| `GET`    | `/{id}/get-questions` | Retrieve all `Question` in `Category`   |
| `GET`    | `/by-user/{user_id}`  | Retrieve `Category` by user ID          |
| `POST`   | `/`                   | Create new `Category`                   |
| `PUT`    | `/{id}`               | Update info `Category` (exclude status) |
| `PATCH`  | `/{id}`               | Change status `Category` only           |
| `DELETE` | `/{id}`               | Delete `Category`                       |

## 5. Question

-   ### Prefix: `/question`

| Method   | Endpoint | Description            |
| -------- | -------- | ---------------------- |
| `GET`    | `/{id}`  | `Question` detail      |
| `POST`   | `/`      | Create new `Question`  |
| `PUT`    | `/{id}`  | Update info `Question` |
| `DELETE` | `/{id}`  | Delete `Question`      |

## 6. Answer

-   ### Prefix: `/answer`

| Method | Endpoint | Description          |
| ------ | -------- | -------------------- |
| `GET`  | `/{id}`  | `Answer` detail      |
| `PUT`  | `/{id}`  | Update info `Answer` |

## 7. Exam

-   ### Prefix: `/exam`

| Method | Endpoint                  | Description                                              |
| ------ | ------------------------- | -------------------------------------------------------- |
| `POST` | `/`                       | `User` join the `Exam`                                   |
| `POST` | `/submit`                 | `User` submit the `Exam`                                 |
| `GET`  | `/`                       | Retrieve all results of `User`                           |
| `GET`  | `/user/{user_id}`         | Retrieve all results of specific `User`                  |
| `GET`  | `/category/{category_id}` | Retrieve all results joined into `Exam` by `Category` ID |

<br>

---

# AUTHORIZATION SYSTEM

## Roles & Permissions

| #   | Role      | Permission                                                                      |
| --- | --------- | ------------------------------------------------------------------------------- |
| 1   | `admin`   | `full-access`                                                                   |
| 2   | `teacher` | `manage-own-category`, `manage-own-question-answer`, `view-own-category-result` |
| 3   | `student` | `join-exam`, `view-result`                                                      |

## Permission describe

| #   | Permission                   | Descriptions                                                             |
| --- | ---------------------------- | ------------------------------------------------------------------------ |
| 1   | `full-access`                | Can `fully access` to the system                                         |
| 2   | `manage-own-category`        | Can **`Create` new & `Edit\|Delete`** `Category` they created            |
| 3   | `manage-own-question-answer` | Can **`Create` new & `Edit\|Delete`** `Question` & `Answer` they created |
| 4   | `view-own-category-result`   | Can view all results of students that join the `Exam` they created       |
| 5   | `join-exam`                  | Can join `Exam`                                                          |
| 6   | `view-result`                | Can view their own `Exam` results                                        |
