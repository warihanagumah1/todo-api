# Todo API
A Laravel-based RESTful API for managing todos. This API provides endpoints for creating, reading, updating, and deleting todos, with support for filtering, sorting, and searching.

Base URL: https://todo-api-fm1j.onrender.com/

## Features
- CRUD operations for todos
- Filter todos by status
- Search todos by title and details
- Sort todos by various fields
- Comprehensive API documentation
- Full test coverage

## API Endpoints & Examples

### GET /api/todos - List all todos
```bash
# Request
GET https://todo-api-fm1j.onrender.com/api/todos

# Response
{
    "data": [
        {
            "id": 1,
            "title": "Complete Documentation",
            "details": "Write API documentation with examples",
            "status": "completed",
            "created_at": "2024-03-15T10:00:00.000000Z",
            "updated_at": "2024-03-15T10:30:00.000000Z"
        }
    ]
}
```

### POST /api/todos - Create a todo
```bash
# Request
POST https://todo-api-fm1j.onrender.com/api/todos
Content-Type: application/json

{
    "title": "New Task",
    "details": "Task details here",
    "status": "not started"
}

# Response
{
    "id": 2,
    "title": "New Task",
    "details": "Task details here",
    "status": "not started",
    "created_at": "2024-03-15T11:00:00.000000Z",
    "updated_at": "2024-03-15T11:00:00.000000Z"
}
```

### PUT /api/todos/{id} - Update a todo
```bash
# Request
PUT https://todo-api-fm1j.onrender.com/api/todos/2
Content-Type: application/json

{
    "status": "completed"
}

# Response
{
    "id": 2,
    "title": "New Task",
    "details": "Task details here",
    "status": "completed",
    "created_at": "2024-03-15T11:00:00.000000Z",
    "updated_at": "2024-03-15T11:30:00.000000Z"
}
```

### DELETE /api/todos/{id} - Delete a todo
```bash
# Request
DELETE https://todo-api-fm1j.onrender.com/api/todos/2

# Response
Status: 204 No Content
```

## Local Development
1. Clone the repository
```bash
git clone https://github.com/warihanagumah1/todo-api.git
cd todo-api
```

2. Install dependencies
```bash
composer install
```

3. Set up environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in .env file

5. Run migrations
```bash
php artisan migrate
```

6. Run tests
```bash
php artisan test
```
The test suite includes:
- can_get_all_todos
- can_filter_todos_by_status
- can_search_todos
- can_create_todo
- can_update_todo
- can_update_todo partial
- can_delete_todo

7. Generate API documentation
```bash
php artisan l5-swagger:generate
```

## API Documentation
Access the API documentation at `/api/documentation`

## Live Demo
- API URL: https://todo-api-fm1j.onrender.com/
- API Documentation: https://todo-api-fm1j.onrender.com/api/documentation

## Built With
- Laravel
- L5-Swagger for API documentation
- PHPUnit for testing