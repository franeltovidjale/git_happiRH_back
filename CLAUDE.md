# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview
HAPPIRH is a Laravel-based HR management application with three main interfaces:
- **Admin**: Laravel + Inertia.js with React frontend
- **Employer/Employee**: Mobile apps consuming Laravel APIs  
- **Public**: Traditional Laravel Blade views with Livewire components

## Development Commands

### Core Laravel Commands
```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Frontend Development
```bash
# Start Vite development server (for admin React components)
npm run dev

# Build frontend assets for production
npm run build

# Install frontend dependencies
npm install
```

### Code Quality & Testing
```bash
# Run Laravel Pint (code formatting)
./vendor/bin/pint

# Run Pest tests
./vendor/bin/pest

# Run PHPUnit tests
php artisan test
```

## Architecture & Structure

### Multi-Interface Architecture
The application serves three distinct user types through different technologies:

1. **Admin Interface** (`routes/admin.php`)
   - Laravel + Inertia.js + React
   - Controllers in `app/Http/Controllers/Admin/`
   - React components served via Inertia

2. **API Interface** (`routes/api.php`, `routes/employer.php`)  
   - RESTful APIs for mobile apps
   - Controllers in `app/Http/Controllers/Api/Employer/` and `app/Http/Controllers/Api/Employee/`
   - JSON responses using base controller methods

3. **Public Interface** (`routes/web.php`)
   - Traditional Blade views with Livewire components
   - Controllers in `app/Http/Controllers/Public/`
   - Livewire components in `app/Livewire/` with corresponding views in `resources/views/livewire/`

### Key Middleware
- `AdminMiddleware`: Protects admin routes
- `EmployerMiddleware`: Protects employer API routes  
- `SetActiveEnterpriseMiddleware`: Sets enterprise context
- `HandleInertiaRequests`: Manages Inertia.js requests

### Authentication System
- Laravel Sanctum for API authentication
- Multi-guard authentication for different user types
- OTP-based login system (`LoginWithOtp` Livewire component)

## Development Conventions

### Code Organization
- Follow Laravel conventions and SOLID principles
- Use appropriate directory structure:
  - Admin controllers: `app/Http/Controllers/Admin/`
  - API controllers: `app/Http/Controllers/Api/Employer/` or `app/Http/Controllers/Api/Employee/`
  - Public controllers: `app/Http/Controllers/Public/`
- Place validation in Request classes, never in controllers
- Use database transactions for critical operations

### Route Conventions
- Use slugs instead of snake_case: `/user-profile` not `/user_profile`
- Organize routes by user type in separate files
- API routes should return JSON responses using base controller methods

### Model Conventions  
- Always define `$fillable` properties
- Add comprehensive PHPDoc comments for properties, relationships, and scopes
- Use camelCase for variables and method names

### Frontend Guidelines
- Admin interface uses React + Inertia.js + Tailwind CSS
- Public interface uses Blade + Livewire + Tailwind CSS  
- Prefer shadcn/ui components before writing custom components
- Use primary color as main, secondary as accent, orange for highlights

### Error Handling
- Use try-catch blocks with proper logging: `logger()->error($e)`
- Wrap critical operations in database transactions
- Return appropriate HTTP status codes for API responses

## Package Ecosystem
- **Laravel 10** with **PHP 8.1+**
- **Livewire 3.6** for dynamic Blade components
- **Inertia.js** with **React 18** for admin interface
- **Sanctum** for API authentication  
- **Pest** for testing
- **Laravel Pint** for code formatting
- **Tailwind CSS** for styling
- **Vite** for asset bundling

## Database
- SQLite for development (`database/database.sqlite`)
- Migrations in `database/migrations/`
- Seeders in `database/seeders/`