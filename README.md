# Todo API

A Laravel-based RESTful API for managing todos. This API provides endpoints for creating, reading, updating, and deleting todos, with support for filtering, sorting, and searching.

## Features

- CRUD operations for todos
- Filter todos by status
- Search todos by title and details
- Sort todos by various fields
- Comprehensive API documentation
- Full test coverage

## API Endpoints

- GET /api/todos - List all todos (with filtering, sorting, and searching)
- POST /api/todos - Create a new todo
- PUT /api/todos/{id} - Update a todo
- DELETE /api/todos/{id} - Delete a todo

## Local Development

1. Clone the repository
```bash
git clone <repository-url>
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

7. Generate API documentation
```bash
php artisan l5-swagger:generate
```

## API Documentation

Access the API documentation at `/api/documentation`

## Live Demo

- API URL: [Your Railway URL]
- API Documentation: [Your Railway URL]/api/documentation

## Testing

Run the test suite:
```bash
php artisan test --coverage
```

## Built With

- Laravel
- L5-Swagger for API documentation
- PHPUnit for testing