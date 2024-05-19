# Task Management

## Overview

This project is a simple Task Management API built with Laravel. It allows users to create, update, fetch, and delete tasks. The API is secured, requiring users to be authenticated to perform any operations on tasks.

## Features

- User authentication and authorization
- CRUD operations on tasks (Create, Read, Update, Delete)
- Feature tests for ensuring the correctness of the API

## Demo

You can check a video demo here: https://youtu.be/B-ClhePkXLU 

## Requirements

- PHP 7.2 or higher
- Composer
- Laravel 7 or 8
- PostgreSQL or any other supported database

## Installation

1. **Clone the repository**:
    ```sh
    git clone https://github.com/your-username/task-management-api.git
    cd task-management-api
    ```

2. **Install dependencies**:
    ```sh
    composer install && npm install
    ```

3. **Copy the `.env` file and configure your environment variables**:
    ```sh
    cp .env.example .env
    ```

4. **Generate an application key**:
    ```sh
    php artisan key:generate
    ```

5. **Set up your database**:
    Update your `.env` file with your database credentials:
    ```env
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=laravel
    DB_USERNAME=laravel
    DB_PASSWORD=laravel
    ```

7. **Run database with docker-compose**:
    ```sh
    docker-compose up -d
    ```

8. **Run database migrations**:
    ```sh
    php artisan migrate
    ```

## Running the Application

1. **Start the development server**:
    ```sh
    php artisan serve
    ```

2. **Build the assets**:
    ```sh
    npm run watch
    ```

3. **Access the application**:
    Open your browser and go to `http://localhost:8000`.

## API Endpoints

### Tasks

- **Get Tasks**: `GET /tasks`
    - Response:
      ```json
      {
        "tasks": [...],
        "userTotalTasks": 5
      }
      ```

- **Create Task**: `POST /tasks`
    - Request:
      ```json
      {
        "title": "New Task",
        "body": "Task details",
        "observation": "Some observations",
        "status": "pending"
      }
      ```
    - Response:
      ```json
      {
        "id": 1,
        "title": "New Task",
        "body": "Task details",
        "observation": "Some observations",
        "status": "pending",
        "user_id": 1,
        "created_at": "2023-05-15T10:00:00.000000Z",
        "updated_at": "2023-05-15T10:00:00.000000Z"
      }
      ```

- **Update Task**: `PUT /tasks/{id}`
    - Request:
      ```json
      {
        "title": "Updated Title",
        "body": "Updated body content",
        "observation": "Updated observation",
        "status": "completed"
      }
      ```
    - Response:
      ```json
      {
        "id": 1,
        "title": "Updated Title",
        "body": "Updated body content",
        "observation": "Updated observation",
        "status": "completed",
        "user_id": 1,
        "created_at": "2023-05-15T10:00:00.000000Z",
        "updated_at": "2023-05-15T10:00:00.000000Z"
      }
      ```

- **Delete Task**: `DELETE /tasks/{id}`
    - Response:
      ```json
      {
        "success": true
      }
      ```

## Running Tests

The project includes feature and unit tests to ensure the functionality of the application.

1. **Run tests**:
    ```sh
    ./vendor/bin/phpunit
    ```

## Directory Structure

```
├── app
│   ├── Console
│   ├── Exceptions
│   ├── Http
│   │   ├── Controllers
│   │   ├── Middleware
│   │   └── Requests
│   ├── Models
│   ├── Providers
│   └── Services
├── bootstrap
├── config
├── database
│   ├── factories
│   ├── migrations
│   └── seeders
├── public
├── resources
├── routes
├── storage
└── tests
    ├── Feature
    └── Unit
```
