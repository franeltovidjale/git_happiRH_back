# HappyHR Development Conventions

## Controller Creation
Place controllers in the appropriate directory based on the functionality:
- **Admin** → `app/Http/Controllers/Admin/`
- **Employer** → `app/Http/Controllers/Employer/`
- **Employee** → `app/Http/Controllers/Employee/`
Never put validation in controller
Always add controller to the corresponding route file

General controllers can be placed in the main controllers directory.

### Database Transactions
Critical code operations must be wrapped in Laravel database transactions using `DB::beginTransaction()`, `DB::commit()`, and `DB::rollback()` to prevent database errors.

### Error Handling
Always use try-catch blocks when necessary for proper error handling.

## Route Creation
Place routes in the appropriate file based on the functionality:
- **Admin** → `routes/admin.php`
- **Employer** → `routes/employer.php`
- **Employee** → `routes/employee.php`

## Validation Request Creation
Place validation requests in the appropriate file based on the functionality:
- **Admin** → `app/Http/Requests/Admin/`
- **Employer** → `app/Http/Requests/Employer/`
- **Employee** → `app/Http/Requests/Employee/`

## Naming Conventions

### Variables and Functions
- Use **camelCase** for variables and function names

### Routes
- Always use **slugs** instead of snake_case for route names
- Example: `/user-profile` instead of `/user_profile`

## Model Conventions

### Fillable Properties
- Always add `$fillable` properties to models
- Include comprehensive PHPDoc comments for auto-completion

### Documentation
- Add PHPDoc comments for all public methods and properties
- Include parameter types and return types in documentation 
