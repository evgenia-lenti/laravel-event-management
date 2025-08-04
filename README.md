# Laravel Event Management System

A comprehensive event management system built with Laravel and Vue.js. This application allows users to create, manage, and register for events.

## Features

- User authentication and role-based authorization
- Event creation and management
- Event registration system
- Dashboard with statistics
- RESTful API with token-based authentication
- Responsive UI built with Vue.js and Tailwind CSS

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL (default) or SQLite

## Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/evgenia-lenti/laravel-event-management.git
cd laravel-event-management
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JavaScript dependencies

```bash
npm install
```

### 4. Configure environment variables

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Set up the database

By default, the application uses MySQL. You'll need to create a database named `event-management`.

```bash
# Create a MySQL database
# You can use your preferred MySQL client or run:
# mysql -u root -e "CREATE DATABASE IF NOT EXISTS `event-management`;"

# Run migrations and seed the database
php artisan migrate --seed
```

If you prefer to use SQLite, update the database configuration in the `.env` file:

```bash
# For SQLite, create the database file
touch database/database.sqlite

# Update .env to use SQLite
# DB_CONNECTION=sqlite
```

### 6. Build frontend assets

```bash
npm run build
```

### 7. Start the development server

```bash
# Option 1: Using the Laravel development server
php artisan serve

# Option 2: Using the custom dev script (runs multiple services)
composer dev
```

The application will be available at http://localhost:8000

## Default Admin Credentials

After seeding the database, you can log in with the following admin accounts:

| Name           | Email                 | Password  |
|----------------|------------------------|-----------|
| Evgenia Lenti  | evgenia@lenti.com     | password  |
| Nikos Ioannidis| nikos@ioannidis.com   | password  |

## Default User Credentials

The database seeder also creates 50 regular users with the "user" role. You can log in with any of these accounts:

| Email                  | Password  | Role  |
|------------------------|-----------|-------|
| [generated-email]      | password  | user  |

The emails for these users are randomly generated during seeding. You can check the database or use any of the seeded user accounts for testing.

## API Documentation

The project includes comprehensive API documentation generated using [Scribe](https://scribe.knuckles.wtf/laravel/). This documentation provides detailed information about all available API endpoints, request parameters, response formats, and authentication requirements.

### Accessing the Documentation

After setting up the application, you can access the API documentation at:

```
http://localhost:8000/docs
```

The documentation includes:
- Interactive API explorer with "Try It Out" functionality
- Authentication instructions
- Request and response examples
- Detailed parameter descriptions

### Generating/Updating Documentation

If you make changes to the API endpoints or want to regenerate the documentation, run:

```bash
php artisan scribe:generate
```

This will update the documentation based on the latest code and annotations in your API controllers.

## Key Design Decisions

### Architecture

- **MVC Pattern**: The application follows the Model-View-Controller pattern for clear separation of concerns.
- **Service Layer**: Business logic is encapsulated in service classes to keep controllers thin.
- **Repository Pattern**: Data access is abstracted through repositories for better testability.
- **Policy-based Authorization**: Laravel policies are used for fine-grained access control.
- **DRY Principle**: Don't Repeat Yourself approach is used throughout the codebase to minimize duplication and improve maintainability.
- **SOLID Principles**: The application follows SOLID design principles for creating more maintainable, extensible, and testable code.

### Frontend

- **Inertia.js**: Used to build a single-page application with Vue.js while leveraging Laravel's routing and controllers.
- **Vue.js 3**: Component-based UI with the Composition API.
- **Tailwind CSS**: Utility-first CSS framework for responsive design.
- **Headless UI**: Accessible UI components for Vue.js.

### API

- **RESTful Design**: The API follows REST principles with resource-based endpoints.
- **API Versioning**: Endpoints are versioned (v1) for better maintainability.
- **Token Authentication**: Laravel Sanctum is used for API authentication.
- **API Documentation**: Scribe is used to generate API documentation.

### Database

- **Migrations**: Database schema is defined using migrations for version control.
- **Seeders**: Sample data is provided through seeders for testing and development.
- **Eloquent ORM**: Laravel's ORM is used for database interactions.
- **Relationships**: Models are related through Eloquent relationships.

### Testing

- **PHPUnit**: Used for unit and feature tests.
- **Factory Pattern**: Test data is generated using factories.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
