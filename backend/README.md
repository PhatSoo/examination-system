# Examination System API <!-- omit from toc -->

## Table of Contents <!-- omit from toc -->

- [GETTING STARTED](#getting-started)
  - [Requirements](#requirements)
  - [Installation](#installation)
      - [1. Clone the repository:](#1-clone-the-repository)
      - [2. Install dependencies:](#2-install-dependencies)
      - [3. Configure environment variables:](#3-configure-environment-variables)
      - [4. Run docker for Mysql _(optional)_:](#4-run-docker-for-mysql-optional)
      - [5. Run migrations \& Create client:](#5-run-migrations--create-client)
      - [6. Run the server:](#6-run-the-server)
- [LIST ENDPOINTS](#list-endpoints)
  - [1. Authentication](#1-authentication)
  - [2. Role](#2-role)
  - [3. Permission](#3-permission)
  - [4. Category](#4-category)
  - [5. Question](#5-question)
  - [6. Answer](#6-answer)
  - [7. Exam](#7-exam)
- [AUTHORIZATION SYSTEM](#authorization-system)
  - [Roles \& Permissions](#roles--permissions)
  - [Permission describe](#permission-describe)
- [ENDPOINT DETAILS](#endpoint-details)
  - [Error Handling](#error-handling)
  - [Request Headers](#request-headers)
  - [Response Structure](#response-structure)
  - [1. Authentication](#1-authentication-1)
    - [_Register_](#register)
    - [_Login_](#login)
    - [_Logout_](#logout)
    - [_Get Current User_](#get-current-user)
  - [2. Role](#2-role-1)
    - [_List_ {#role}](#list-role)
    - [_Detail_ {#role}](#detail-role)
    - [_Add Permission_](#add-permission)
  - [3. Permission](#3-permission-1)
    - [_List_ {#permission}](#list-permission)
    - [_Detail_ {#permission}](#detail-permission)
  - [4. Category](#4-category-1)
    - [_List_ {#category}](#list-category)
    - [_Detail_ {#category}](#detail-category)
    - [_List By Author_ {#category}](#list-by-author-category)
    - [_List all question_ {#category}](#list-all-question-category)
    - [_Create_ {#category}](#create-category)
    - [_Update_ {#category}](#update-category)
    - [_Change Status_ {#category}](#change-status-category)
    - [_Delete_ {#category}](#delete-category)
  - [5. Question](#5-question-1)
    - [_Detail_ {#question}](#detail-question)
    - [_Create_ {#question}](#create-question)
    - [_Update_ {#question}](#update-question)
    - [_Delete_ {#question}](#delete-question)
  - [6. Answer](#6-answer-1)
    - [_Detail_ {#answer}](#detail-answer)
    - [_Update_ {#answer}](#update-answer)
  - [7. Exam](#7-exam-1)
    - [_Join_ {#exam}](#join-exam)
    - [_Submit_ {#exam}](#submit-exam)
    - [_Result_ {#exam}](#result-exam)
    - [_Result by UserID_ {#exam}](#result-by-userid-exam)
    - [_Result by Category_ {#exam}](#result-by-category-exam)

# GETTING STARTED

> # REST API for Examination System

## Requirements

```
PHP >= 8.0
Laravel >= 11.x
MySQL (Docker)
```

## Installation

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

| Method | Endpoint    | Description                    |
| ------ | ----------- | ------------------------------ |
| `POST` | `/login`    | [User login](#login)           |
| `POST` | `/register` | [User register](#register)     |
| `POST` | `/logout`   | [User logout](#logout)         |
| `GET`  | `/profile`  | [User info](#get-current-user) |

## 2. Role

-   ### Prefix: `/role`

| Method | Endpoint               | Description                                            |
| ------ | ---------------------- | ------------------------------------------------------ |
| `GET`  | `/`                    | [Retrieve all `Role`](#list-role)                      |
| `GET`  | `/{id}`                | [`Role` detail](#detail-role)                          |
| `POST` | `/add-permission/{id}` | [Add or Remove Permission for `Role`](#add-permission) |

## 3. Permission

-   ### Prefix: `/permission`

| Method | Endpoint | Description                                   |
| ------ | -------- | --------------------------------------------- |
| `GET`  | `/`      | [Retrieve all `Permission`](#list-permission) |
| `GET`  | `/{id}`  | [`Permission` detail](#detail-permission)     |

## 4. Category

-   ### Prefix: `/category`

| Method   | Endpoint              | Description                                                          |
| -------- | --------------------- | -------------------------------------------------------------------- |
| `GET`    | `/`                   | [Retrieve all `Category`](#list-category)                            |
| `GET`    | `/{id}`               | [`Category` detail](#detail-category)                                |
| `GET`    | `/{id}/get-questions` | [Retrieve all `Question` in `Category`](#list-all-question-category) |
| `GET`    | `/by-user/{user_id}`  | [Retrieve `Category` by user ID](#list-by-author-category)           |
| `POST`   | `/`                   | [Create new `Category`](#create-category)                            |
| `PUT`    | `/{id}`               | [Update info `Category` (exclude status)](#update-category)          |
| `PATCH`  | `/{id}`               | [Change status `Category` only](#change-status-category)             |
| `DELETE` | `/{id}`               | [Delete `Category`](#delete-category)                                |

## 5. Question

-   ### Prefix: `/question`

| Method   | Endpoint | Description                                |
| -------- | -------- | ------------------------------------------ |
| `GET`    | `/{id}`  | [`Question` detail](#detail-question)      |
| `POST`   | `/`      | [Create new `Question`](#create-question)  |
| `PUT`    | `/{id}`  | [Update info `Question`](#update-question) |
| `DELETE` | `/{id}`  | [Delete `Question`](#delete-question)      |

## 6. Answer

-   ### Prefix: `/answer`

| Method | Endpoint | Description                            |
| ------ | -------- | -------------------------------------- |
| `GET`  | `/{id}`  | [`Answer` detail](#detail-answer)      |
| `PUT`  | `/{id}`  | [Update info `Answer`](#update-answer) |

## 7. Exam

-   ### Prefix: `/exam`

| Method | Endpoint                  | Description                                                                          |
| ------ | ------------------------- | ------------------------------------------------------------------------------------ |
| `POST` | `/`                       | [`User` join the `Exam`](#join-exam)                                                 |
| `POST` | `/submit`                 | [`User` submit the `Exam`](#submit-exam)                                             |
| `GET`  | `/`                       | [Retrieve all results of `User`](#result-exam)                                       |
| `GET`  | `/user/{user_id}`         | [Retrieve all results of specific `User`](#result-by-userid-exam)                    |
| `GET`  | `/category/{category_id}` | [Retrieve all results joined into `Exam` by `Category` ID](#result-by-category-exam) |

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

<br>

---

# ENDPOINT DETAILS

## Error Handling

| Status Code | Message                 | Description                                                           |
| ----------- | ----------------------- | --------------------------------------------------------------------- |
| `400`       | `Bad request`           | The server could not understand the request due to invalid syntax.    |
| `401`       | `Unauthorized`          | Authentication is required and has failed or not been provided.       |
| `403`       | `Forbidden`             | The client does not have access rights to the content.                |
| `404`       | `Not found`             | The content does not found.                                           |
| `500`       | `Internal server error` | The server has encountered a situation it doesn't know how to handle. |

## Request Headers

| Header          | Type     | Validation | Description                    |
| --------------- | -------- | ---------- | ------------------------------ |
| `Authorization` | `string` | Required   | Bearer token for authorization |

## Response Structure

```json
{
  "status": "success" || "failed",      // "success" if status = 2**, otherwise return "failed"
  "statusCode": 200,                    // request status
  "message": "...",                     // error message or response message
  "data": [ ... ]                       // return data (if exist). default: null
}
```

## 1. Authentication

### _Register_

-   **Endpoint:** `/register`
-   **Method:** `POST`
-   **Description:** Register a new user account.

    #### **Request Body**

    | Field                   | Type     | Validation | Description           |
    | ----------------------- | -------- | ---------- | --------------------- |
    | `name`                  | `string` | Required   | User's full name      |
    | `email`                 | `string` | Required   | User's email address  |
    | `password`              | `string` | Required   | User's password       |
    | `password_confirmation` | `string` | Required   | Password confirmation |

    #### **Response**

    -   **201 Created**: Registration success.
        ```json
        {
            "message": "Create new Account success"
        }
        ```
    -   **400 Bad Request**: Validation error (e.g., email already exists, password confirmation does not match).

        ```json
        {
            "message": {
                "email": ["email is already existed"],
                "password": ["The password field confirmation does not match."]
            }
        }
        ```

    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Login_

-   **Endpoint:** `/login`
-   **Method:** `POST`
-   **Description:** Authenticate user and return an access token.

    #### **Request Body**

    | Field      | Type     | Validation | Description          |
    | ---------- | -------- | ---------- | -------------------- |
    | `email`    | `string` | Required   | User's email address |
    | `password` | `string` | Required   | User's password      |

    #### **Response**

    -   **200 Created**: Login success.
        ```json
        {
            "message": "Login success!",
            "data": {
                "token": "your-access-token"
            }
        }
        ```
    -   **400 Bad Request**: Validation error (e.g., invalid email).

        ```json
        {
            "message": {
                "email": ["The email field must be a valid email address."]
            }
        }
        ```

    -   **401 Unauthorized**: Wrong login info.

        ```json
        {
            "message": "Login Failed"
        }
        ```

    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Logout_

-   **Endpoint:** `/logout`
-   **Method:** `POST`
-   **Description:** Logout the user and invalidate the access token.
-   **Required Login:** view at [Request Header](#request-headers)

    #### Response

    -   **200 OK**: Logout success.
        ```json
        {
            "message": "Logout success!"
        }
        ```
    -   **401 Unauthorized**: view at [Error Handling](#error-handling)

    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Get Current User_

-   **Endpoint:** `/user`
-   **Method:** `GET`
-   **Description:** Retrieve the profile of the authenticated user.
-   **Required Login:** view at [Request Header](#request-headers)

    #### Response

    -   **200 OK**: Return authenticated user profile.
        ```json
        {
            "message": "Get profile success!",
            "data": {
                "id": "user-id",
                "name": "user-name",
                "email": "user-email",
                "email_verified_at": null,
                "role_id": "role-id",
                "role": {
                    "id": "role-id",
                    "name": "role-name"
                }
            }
        }
        ```
    -   **401 Unauthorized**: view at [Error Handling](#error-handling)

    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

## 2. Role

### _List_ {#role}

-   **Prefix:** `/role`
-   **Endpoint:** `/`
-   **Method:** `GET`
-   **Description:** Retrieve all roles.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`full-access`](#permission-describe)

    #### **Request Parameters**

    | Field        | Value | Validation | Description                    |
    | ------------ | ----- | ---------- | ------------------------------ |
    | `permission` | true  | Optional   | Get all `Permission` of `Role` |

    #### **Response**

    -   **200 OK**: Get all roles success.

        ```json
        {
            "message": "Retrieve all Role success",
            "data": {
                "id": "role-id",
                "name": "role-name"
            }
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Detail_ {#role}

-   **Prefix:** `/role`
-   **Endpoint:** `/{id}`
-   **Method:** `GET`
-   **Description:** Retrieve Role by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`full-access`](#permission-describe)

    #### **Request Parameters**

    | Field        | Value | Validation | Description                    |
    | ------------ | ----- | ---------- | ------------------------------ |
    | `permission` | true  | Optional   | Get all `Permission` of `Role` |

    #### **Response**

    -   **200 OK**: Get Role success.

        ```json
        {
            "message": "Retrieve Role with ID::{id} success",
            "data": {
                "id": "role-id",
                "name": "role-name",
                "permissions": [
                    // if has permission = true param
                    {
                        "id": "permission-id",
                        "name": "permission-name",
                        "description": "permission-describe"
                    }
                ]
            }
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Add Permission_

-   **Prefix:** `/role`
-   **Endpoint:** `/add-permission/{id}`
-   **Method:** `POST`
-   **Description:** Add/Remove permission for Role ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`full-access`](#permission-describe)

    #### **Request Body**

    | Field        | Type    | Validation                                    | Description              |
    | ------------ | ------- | --------------------------------------------- | ------------------------ |
    | `permission` | `array` | - Required <br> - Existed in Permission Table | Array of `Permission` ID |

    #### **Response**

    -   **201 Created**: Add permission to Role success.

        ```json
        {
            "message": "Add Permissions to Role success"
        }
        ```

    -   **400 Bad Request**: Validation error (e.g., permission_id does not exist).
    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

## 3. Permission

### _List_ {#permission}

-   **Prefix:** `/permission`
-   **Endpoint:** `/`
-   **Method:** `GET`
-   **Description:** Retrieve all permissions.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`full-access`](#permission-describe)

    #### **Request Parameters**

    | Field  | Value | Validation | Description         |
    | ------ | ----- | ---------- | ------------------- |
    | `role` | true  | Optional   | Include `Role` info |

    #### **Response**

    -   **200 OK**: Get all permissions success.

        ```json
        {
            "message": "Retrieve all Permission success",
            "data": {
                "id": "permission-id",
                "name": "permission-name",
                "description": "permission-describe"
            }
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Detail_ {#permission}

-   **Prefix:** `/permission`
-   **Endpoint:** `/{id}`
-   **Method:** `GET`
-   **Description:** Retrieve Permission by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`full-access`](#permission-describe)

    #### **Request Parameters**

    | Field  | Value | Validation | Description         |
    | ------ | ----- | ---------- | ------------------- |
    | `role` | true  | Optional   | Include `Role` info |

    #### **Response**

    -   **200 OK**: Get permission success.

        ```json
        {
            "message": "Retrieve Permission success",
            "data": {
                "id": "permission-id",
                "name": "permission-name",
                "description": "permission-describe",
                "roles": [
                    {
                        "id": "role-id",
                        "name": "role-name"
                    }
                ]
            }
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

## 4. Category

### _List_ {#category}

-   **Prefix:** `/category`
-   **Endpoint:** `/`
-   **Method:** `GET`
-   **Description:** Retrieve all categories.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)

    #### **Request Parameters**

    | Field   | Value | Validation | Description                                  |
    | ------- | ----- | ---------- | -------------------------------------------- |
    | `owner` | true  | Optional   | Get all `Category` of the Authenticated User |

    #### **Response**

    -   **200 OK**: Get all permissions success.

        ```json
        {
            "message": "Retrieve all Category success",
            "data": [
                {
                    "id": "category-id",
                    "name": "category-name",
                    "slug": "category-slug",
                    "image_url": null,
                    ...
                },
            ]
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Detail_ {#category}

-   **Prefix:** `/category`
-   **Endpoint:** `/{id}`
-   **Method:** `GET`
-   **Description:** Retrieve Category by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)

    #### **Request Parameters**

    | Field      | Value | Validation | Description         |
    | ---------- | ----- | ---------- | ------------------- |
    | `userInfo` | true  | Optional   | Include Author info |

    #### **Response**

    -   **200 OK**: Get permission success.

        ```json
        {
            "message": "Retrieve Category with ID:{id} success",
            "data": {
                "id": "category-id",
                "name": "category-name",
                "slug": "category-slug",
                "image_url": null,
                ...
            },

        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _List By Author_ {#category}

-   **Prefix:** `/category`
-   **Endpoint:** `/by-user/{user-id}`
-   **Method:** `GET`
-   **Description:** Retrieve all categories of User ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)

    #### **Response**

    -   **200 OK**: Get all permissions success.

        ```json
        {
            "message": "Retrieve all Category by User ID success",
            "data": [
                {
                    "id": "category-id",
                    "name": "category-name",
                    "slug": "category-slug",
                    "image_url": null,
                    ...
                },
            ]
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _List all question_ {#category}

-   **Prefix:** `/category`
-   **Endpoint:** `/{id}/get-questions`
-   **Method:** `GET`
-   **Description:** Retrieve all questions of Category ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-category` ,`full-access`](#permission-describe)

    #### **Response**

    -   **200 OK**: request success.

        ```json
        {
            "message": "Retrieve Answers of Category with ID::2 success.",
            "data": [
                {
                    "id": "question-id",
                    "name": "question-name",
                    "difficulty": "question-difficulty",
                    "image_url": null,
                    ...
                },
            ]
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Create_ {#category}

-   **Prefix:** `/category`
-   **Endpoint:** `/`
-   **Method:** `POST`
-   **Description:** Create new Category.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`create-category` ,`full-access`](#permission-describe)

    #### **Request Body**

    | Field          | Type     | Validation | Description              |
    | -------------- | -------- | ---------- | ------------------------ |
    | `name`         | `string` | Required   | Category title           |
    | `num_question` | `number` | Required   | The number of questions  |
    | `total_time`   | `number` | Required   | Duration to do this exam |
    | `image_url`    | `string` | Required   | Image                    |

    #### **Response**

    -   **201 Created**: request success.

        ```json
        {
            "message": "Create new Category success."
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Update_ {#category}

-   **Prefix:** `/category/{id}`
-   **Endpoint:** `/`
-   **Method:** `PUT`
-   **Description:** Update Category by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-category` ,`full-access`](#permission-describe)

    #### **Request Body**

    | Field          | Type     | Validation | Description              |
    | -------------- | -------- | ---------- | ------------------------ |
    | `name`         | `string` | Optional   | Category title           |
    | `num_question` | `number` | Optional   | The number of questions  |
    | `total_time`   | `number` | Optional   | Duration to do this exam |
    | `image_url`    | `string` | Optional   | Image                    |

    #### **Response**

    -   **204 No Content**: request success.

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Change Status_ {#category}

-   **Prefix:** `/category/{id}`
-   **Endpoint:** `/`
-   **Method:** `PATCH`
-   **Description:** Change Status Category by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-category` ,`full-access`](#permission-describe)

    #### **Request Body**

    | Field    | Type   | Validation                                    | Description               |
    | -------- | ------ | --------------------------------------------- | ------------------------- |
    | `status` | `enum` | - Required <br> - [pending, active, inactive] | Change status of Category |

    #### **Response**

    -   **204 No Content**: request success.

    -   **400 Bad Request**:

        ```json
        {
            "message": "Unsuitable status..."
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Delete_ {#category}

-   **Prefix:** `/category/{id}`
-   **Endpoint:** `/`
-   **Method:** `DELETE`
-   **Description:** Delete Category by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-category` ,`full-access`](#permission-describe)

    #### **Response**

    -   **200 OK**: request success.

    ```json
    {
        "message": "Remove Category with ID::${id} success"
    }
    ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

## 5. Question

### _Detail_ {#question}

-   **Prefix:** `/question`
-   **Endpoint:** `/{id}`
-   **Method:** `GET`
-   **Description:** Retrieve Question by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-question-answer` ,`full-access`](#permission-describe)

    #### **Request Parameters**

    | Field      | Value | Validation | Description                          |
    | ---------- | ----- | ---------- | ------------------------------------ |
    | `category` | true  | Optional   | Include Category info                |
    | `answers`  | true  | Optional   | Include all Answers of this Question |

    #### **Response**

    -   **200 OK**: Get question success.

        ```json
        {
            "message": "Retrieve Question with ID::{id} success",
            "data": {
                "title": "question-title",
                "difficulty": "question-difficulty",
                "category_id": "category-id",
                "user_id": "created-user-id",
                "image_url": null,
                ...
            },

        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Create_ {#question}

-   **Prefix:** `/question`
-   **Endpoint:** `/`
-   **Method:** `POST`
-   **Description:** Create new question with 4 answers.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-question-answer`, `manage-own-category`,`full-access`](#permission-describe)

    #### **Request Body**

    | Field                | Type      | Conditions                                                             | Description        |
    | -------------------- | --------- | ---------------------------------------------------------------------- | ------------------ |
    | `title`              | `string`  | Required                                                               | Question title     |
    | `image_url`          | `string`  | Required                                                               | Image's question   |
    | `difficulty`         | `enum`    | - Required <br> - [easy, medium, hard]                                 | Question difficult |
    | `category_id`        | `number`  | - Required <br> - Existed in Permission Table                          | Question Category  |
    | `answers`            | `array`   | - Required <br> - Length required == 4                                 | Question's answers |
    | `answers.title`      | `string`  | - Required <br> - if answer.type === image this should be an Image URL | Question's answers |
    | `answers.is_correct` | `boolean` | - Required                                                             | Question's answers |
    | `answers.type`       | `enum`    | - Required <br> - [text, image]                                        | Question's answers |

    #### **Response**

    -   **201 Created**: Create question success.

        ```json
        {
            "message": "Retrieve Question with ID::{id} success",
            "data": {
                "title": "question-title",
                "difficulty": "question-difficulty",
                "category_id": "category-id",
                "user_id": "created-user-id",
                "image_url": null,
                ...
            },

        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Update_ {#question}

-   **Prefix:** `/question/{id}`
-   **Endpoint:** `/`
-   **Method:** `PUT`
-   **Description:** Update Question by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-category` ,`full-access`](#permission-describe)

    #### **Request Body**

    | Field         | Type     | Validation                                    | Description          |
    | ------------- | -------- | --------------------------------------------- | -------------------- |
    | `title`       | `string` | Optional                                      | Question title       |
    | `image_url`   | `string` | Optional                                      | Image url (nullable) |
    | `difficulty`  | `enum`   | - Optional <br> - [easy, medium, hard]        | Question difficult   |
    | `category_id` | `number` | - Optional <br> - Existed in Permission Table | Question's category  |

    #### **Response**

    -   **204 No Content**: request success.

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Delete_ {#question}

-   **Prefix:** `/question/{id}`
-   **Endpoint:** `/`
-   **Method:** `DELETE`
-   **Description:** Delete Question by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-question-answer` ,`full-access`](#permission-describe)

    #### **Response**

    -   **200 OK**: request success.

    ```json
    {
        "message": "Remove Question with ID::${id} success"
    }
    ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

## 6. Answer

### _Detail_ {#answer}

-   **Prefix:** `/answer`
-   **Endpoint:** `/{id}`
-   **Method:** `GET`
-   **Description:** Retrieve Answer by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)

    #### **Response**

    -   **200 OK**: Get answer success.

        ```json
        {
            "message": "Retrieve Answer with ID::{id} success",
            "data": {
                "id": "answer-id",
                "question_id": "question-id",
                "is_correct": "is this a correct answer",
                "title": "answer-title",
                "type": "image | text"
            }
        }
        ```

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

### _Update_ {#answer}

-   **Prefix:** `/answer/{id}`
-   **Endpoint:** `/`
-   **Method:** `PUT`
-   **Description:** Update Answer by ID.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-question-answer` ,`full-access`](#permission-describe)

    #### **Request Body**

    | Field        | Type      | Validation                      | Description                       |
    | ------------ | --------- | ------------------------------- | --------------------------------- |
    | `title`      | `string`  | Optional                        | Answer title                      |
    | `is_correct` | `boolean` | Optional                        | Is this a correct answer or not ? |
    | `type`       | `enum`    | - Optional <br> - [image, text] | Answer has image in title         |

    #### **Response**

    -   **204 No Content**: request success.

    -   **401 Unauthorized**: view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error**: view at [Error Handling](#error-handling)

## 7. Exam

### _Join_ {#exam}

-   **Prefix:** `/exam`
-   **Endpoint:** `/`
-   **Method:** `POST`
-   **Description:** Join the exam.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)

    #### **Request Body**

    | Field         | Type     | Conditions                                  | Description                |
    | ------------- | -------- | ------------------------------------------- | -------------------------- |
    | `category_id` | `number` | - Required <br> - Existed in Category table | Category to start the exam |

    #### **Response**

    -   **201 Created**: Create question success.

        ```json
        {
            "message": "Create new Exam success"
        }
        ```

    -   **400 Bad Request:**

    ```json
    {
        "message": {
            "category_id": ["The selected category id is invalid."]
        }
    }
    ```

    -   **401 Unauthorized:** view at [Error Handling](#error-handling)
    -   **500 Internal Server Error:** view at [Error Handling](#error-handling)

### _Submit_ {#exam}

-   **Prefix:** `/exam`
-   **Endpoint:** `/submit`
-   **Method:** `POST`
-   **Description:** Submit the exam.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)

    #### **Request Body**

    | Field              | Type     | Conditions                              | Description                      |
    | ------------------ | -------- | --------------------------------------- | -------------------------------- |
    | `exam_id`          | `number` | - Required <br> - Existed in Exam table | Exam ID                          |
    | `data`             | `array`  | - Required                              | User's choice for every question |
    | `data.question_id` | `number` | - Required                              | Question in the Exam             |
    | `data.user_choice` | `number` | - Required                              | User's choice for Question       |

    #### **Response**

    -   **200 OK**: request success.

        ```json
        {
            "message": "Calculate the Exam score success.",
            "data": {
                "score": "user score",
                "detail": {
                    "question_id": "question-id",
                    "user_choice": "user-choice",
                    "status": "true | false" // true if user choose correct
                }
            }
        }
        ```

    -   **401 Unauthorized:** view at [Error Handling](#error-handling)
    -   **404 Not Found:** view at [Error Handling](#error-handling)
    -   **500 Internal Server Error:** view at [Error Handling](#error-handling)

### _Result_ {#exam}

-   **Prefix:** `/exam`
-   **Endpoint:** `/result`
-   **Method:** `GET`
-   **Description:** Get all results of Authenticated User.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)

    #### **Request Params**

    | Field      | Type     | Conditions | Description                |
    | ---------- | -------- | ---------- | -------------------------- |
    | `category` | `number` | Optional   | Get all result by Category |

    #### **Response**

    -   **200 OK**: request success.

        ```json
        {
            "message": "Retrieve all results of User ID::2 success.",
            "data": [
                {
                    "id": "exam-id",
                    "user_id": "user-id",
                    "category_id": "category-id",
                    "score": "exam-score",
                    "start-time": "time the exam start",
                    "end-time": "time after add duration to start-time"
                }
            ]
        }
        ```

    -   **401 Unauthorized:** view at [Error Handling](#error-handling)
    -   **500 Internal Server Error:** view at [Error Handling](#error-handling)

### _Result by UserID_ {#exam}

-   **Prefix:** `/exam`
-   **Endpoint:** `/user/{user-id}`
-   **Method:** `GET`
-   **Description:** Get all results of Specific User.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`full-access`](#permission-describe)

    #### **Request Params**

    | Field      | Type     | Conditions | Description                |
    | ---------- | -------- | ---------- | -------------------------- |
    | `category` | `number` | Optional   | Get all result by Category |

    #### **Response**

    -   **200 OK**: request success.

        ```json
        {
            "message": "Retrieve all results of User ID::2 success.",
            "data": [
                {
                    "id": "exam-id",
                    "user_id": "user-id",
                    "category_id": "category-id",
                    "score": "exam-score",
                    "start-time": "time the exam start",
                    "end-time": "time after add duration to start-time"
                }
            ]
        }
        ```

    -   **401 Unauthorized:** view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error:** view at [Error Handling](#error-handling)

### _Result by Category_ {#exam}

-   **Prefix:** `/exam`
-   **Endpoint:** `/category/{category-id}`
-   **Method:** `GET`
-   **Description:** Get all results of Specific User.
-   **Conditions:**

    -   **Required Login:** view at [Request Header](#request-headers)
    -   **Required Permissions:** [`manage-own-category`, `full-access`](#permission-describe)

    #### **Response**

    -   **200 OK**: request success.

        ```json
        {
            "message": "Retrieve all results of Category ID::{id} success.",
            "data": [
                {
                    "id": "exam-id",
                    "user_id": "user-id",
                    "category_id": "category-id",
                    "score": "exam-score",
                    "start-time": "time the exam start",
                    "end-time": "time after add duration to start-time"
                }
            ]
        }
        ```

    -   **401 Unauthorized:** view at [Error Handling](#error-handling)
    -   **403 Forbidden**: view at [Error Handling](#error-handling)
    -   **404 Not Found**: view at [Error Handling](#error-handling)
    -   **500 Internal Server Error:** view at [Error Handling](#error-handling)
