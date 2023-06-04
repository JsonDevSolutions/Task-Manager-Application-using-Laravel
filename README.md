# SIMPLE TASK MANAGEMENT USING LARAVEL API
## Video Site Link [visit output demo]([https://youtu.be/QfsQarqoUPs](https://task-management-api.jsondev-solutions.com/)).
## Video Demo Link [visit demo](https://youtu.be/QfsQarqoUPs).
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

### Endpoint for demonstration with Front End
##### Files `routes/web.php` and `resources/views/tasks.blade.php`
- Demonstrations for REST API with Frond End: `GET /tasks`

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
##### Sample Validation Errors:
    1. Empty title field and invalid due date
    {
        "title": [
            "The title field is required."
        ],
        "due_date": [
            "The due date must be a date after today."
        ]
    }

    2. Title field is more than 10 characters
    {
        "title": [
            "The title must not be greater than 10 characters."
        ]
    }
    3. When the resoure doesn't exist and you try to access, update or delete
    {
        "message": "Record not found."
    }
### Endpoints
- Get all tasks: `GET /api/v2/tasks`

- Get a single task: `GET /api/v2/tasks/{id}`

- Create a new task: POST `/api/v2/tasks`

- Update a task: PUT `/api/v2/tasks/{id}`

- Delete a task: DELETE `/api/v2/tasks/{id}`

## Problem 3: Add Pagination and Sorting
##### v3 - Basic REST API with Pagination and Sorting
##### Parameters 
    page_number =>  "optional"   Page number of the paginated task list. Default value: 1.
    per_page    =>  "optional"   Number of results that will be displayed per page. possible values (10, 25, 50, 100. Defaults value: 10).
    sort_by     =>  "optional"   Sort by possible values ('id', 'title' or 'due_date'. Defaults value: 'id').
    sort        =>  "optional"   Results Sorting, possible values ('asc', 'desc'. Default value: 'desc').

##### Files `routes/api_v3.php` and `app\Http\Controllers\Api\v3\TaskController.php`
##### Sample Response:
    {
        "data": [ ... ], 10 items
        "meta": {
            "current_page": 1,
            "total": 50,
            "per_page": 10,
            "total_pages": 5
        }
    }
##### Sample Validation Errors if parameters is invalid:
    {
        "per_page": [
            "The per_page field possible values are: 10, 25, 50, 100. Defaults value: 10"
        ],
        "sort_by": [
            "The sort_by field must be either 'id', 'title' or 'due_date'."
        ],
        "sort": [
            "The sort field must be either 'asc' or 'desc'."
        ]
    }
### Endpoints
- Get paginated list of task: `GET /api/v3/tasks/?page_number={page_number}&per_page={per_page}&sort_by={sort_by}&sort={sort}`

- Get a single task: `GET /api/v3/tasks/{id}`

- Create a new task: POST `/api/v3/tasks`

- Update a task: PUT `/api/v3/tasks/{id}`

- Delete a task: DELETE `/api/v3/tasks/{id}`

## SUMMARY
##### Basic REST API with Validation, Pagination and Sorting
- `'GET' /api/v3/tasks/?page_number={page_number}&per_page={per_page}&sort_by={sort_by}&sort={sort}`
    ##### Parameters 
        page_number =>  "optional"   Page number of the paginated task list. Default value: 1.
        per_page    =>  "optional"   Number of results that will be displayed per page. possible values (10, 25, 50, 100. Defaults value: 10).
        sort_by     =>  "optional"   Sort by possible values ('id', 'title' or 'due_date'. Defaults value: 'id').
        sort        =>  "optional"   Results Sorting, possible values ('asc', 'desc'. Default value: 'desc').

- `'POST' /api/v3/tasks`
    ##### Parameters 
        title       =>  "required"   Task Title that should not be more than 10 chars for testing purposes.
        description =>  "optional"   Task Description.
        due_date    =>  "required"   Task Due date.
- `'PUT' or 'PATCH' /api/v3/tasks/{id}`
    ##### Parameters 
        title       =>  "required"   Task Title that should not be more than 10 chars for testing purposes.
        description =>  "optional"   Task Description.
        due_date    =>  "required"   Task Due date.
        _method     =>  "required"   Value must be `PUT` or `PATCH`. sample error if not included `error: "Method not allowed."`
- `GET /api/v3/tasks/{id}`
- ` DELETE /api/v3/tasks/{id}`
