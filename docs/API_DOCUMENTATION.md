# BudgetX API Documentation

## Authentication (Sanctum)
All protected endpoints require a Bearer token in the Authorization header.

### `POST /api/register`
Registers a new user.
- **Body**: `name`, `email`, `password`, `password_confirmation`, `device_name` (optional).

### `POST /api/login`
Authenticates a user.
- **Body**: `email`, `password`, `device_name` (optional).

### `POST /api/logout` (Auth required)
Revokes the current access token.

### `POST /api/logout-all` (Auth required)
Revokes all access tokens for the user.

## Resources
Standard CRUD operations for the following resources (requires Auth):
- `GET /api/budgets`
- `POST /api/budgets`
- `GET /api/budgets/{id}`
- `PUT /api/budgets/{id}`
- `DELETE /api/budgets/{id}`

(Also applies to `/api/expenses` and `/api/categories`)

## Advanced Querying
- **Pagination**: Use `?page=2&per_page=15`
- **Filtering**: Use `?filter[status]=active`
- **Sorting**: Use `?sort=-created_at,name` (prefix with `-` for descending).
- **Searching**: Use `?search=keyword`

## Admin Panel
- `GET /api/admin/dashboard`: Returns aggregate statistics. Requires Admin role.
