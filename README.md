# SIMPLE TASK MANAGEMENT USING LARAVEL API

## Setup and Configuration
- First time to use Laravel? Download [Composer](https://getcomposer.org/) and install.
- Clone Repository `https://github.com/JsonDevSolutions/Task-Manager-Application-using-Laravel.git`.
- Run `composer install`
- Create a database locally named `task_manager` utf8_general_ci.
- Open `.env` file in your root directory and configure your mysql database credentials.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=task_manager 
    DB_USERNAME=root        [Replace with your database username]
    DB_PASSWORD=admin123    [Replace with your database password]
    ```
- Run `php artisan migrate`
- Run `php artisan db:seed` to run seeders to test pagination.
- Run `php artisan serve`

##### You can now access your project at localhost:8000 :)

## If for some reason your project stop working do these:
- `composer install`
- `php artisan migrate`

## Problem 1: Create an API for a Task Manager
##### v1 - Basic REST API without any validations
##### Files `routes/api_v1.php` and `app\Http\Controllers\Api\v1\TaskController.php`
### Endpoints
- Get all tasks: `GET /api/v1/tasks`

- Get a single task: `GET /api/v1/tasks/{id}`

- Create a new task: POST `/api/v1/tasks`

- Update a task: PUT `/api/v1/tasks/{id}`

- Delete a task: DELETE `/api/v1/tasks/{id}`

## Problem 2: Implement Data Validation
##### v2 - Basic REST API with validations
##### Validation Rules : `Title should not be Empty and should not exceed 10 characters.` and `Due Date should be a valid date in the future`
##### Files `routes/api_v2.php` and `app\Http\Controllers\Api\v2\TaskController.php`
### Endpoints
- Get all tasks: `GET /api/v2/tasks`

- Get a single task: `GET /api/v2/tasks/{id}`

- Create a new task: POST `/api/v2/tasks`

- Update a task: PUT `/api/v2/tasks/{id}`

- Delete a task: DELETE `/api/v2/tasks/{id}`

## Problem 3: Add Pagination and Sorting
##### v3 - Basic REST API with Pagination and Sorting
##### Parameters []
##### Files `routes/api_v3.php` and `app\Http\Controllers\Api\v3\TaskController.php`
### Endpoints
- Get paginated list of task: `GET /api/v3/tasks/?page_number={page_number}&per_page={per_page}&sort_by={sort_by}&sort={sort}`

- Get a single task: `GET /api/v3/tasks/{id}`

- Create a new task: POST `/api/v3/tasks`

- Update a task: PUT `/api/v3/tasks/{id}`

- Delete a task: DELETE `/api/v3/tasks/{id}`
