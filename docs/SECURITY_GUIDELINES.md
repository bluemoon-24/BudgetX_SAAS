# Security Guidelines

## Authentication & Authorization
- **Sanctum**: We use Laravel Sanctum for API token management. Tokens expire after 24 hours.
- **RBAC**: Spatie Laravel-Permission is used. Users have roles (`user`, `admin`).
- **Policies**: Every resource (Budget, Expense, Category) has a Policy ensuring users can only access their own data, while Admins have full access.

## Data Protection
- **Mass Assignment**: Models use `$fillable` arrays to prevent mass assignment vulnerabilities.
- **Hidden Attributes**: Sensitive data like `password` and `remember_token` are hidden from API responses.
- **Validation**: All API endpoints use strict Form Requests to validate and sanitize incoming data, mitigating XSS and SQL Injection.

## Global Exception Handling
- The `bootstrap/app.php` file intercepts common exceptions (Authentication, NotFound, Validation) and guarantees a consistent JSON format without exposing sensitive stack traces.
