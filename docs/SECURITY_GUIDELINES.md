# BudgetX Security Guidelines

This document describes the security controls implemented in the BudgetX Laravel application. Email verification is intentionally not part of the authentication contract. Password reset remains enabled.

## Findings Classification

### CRITICAL

None identified in the final review.

### IMPORTANT

The following confirmed issues were fixed:

- **Category relationship IDOR:** web requests could previously submit another user's category ID when creating budgets, expenses, or incomes. The relevant Form Requests now restrict categories to system categories or the authenticated user's own categories on every request path.
- **Blocked API account bypass:** blocked users could previously log in through the API, and existing Sanctum tokens were not checked by the status middleware. API login now rejects blocked accounts; protected API requests check account status, return JSON `403`, and revoke the current token.
- **Stripe payment trust:** Premium access and paid transactions require verified Stripe Checkout sessions. Verification checks session identity, authenticated-user ownership, metadata, plan, subscription mode, payment status, amount, currency, recurring interval, and product. Stripe failures never create paid transactions or grant Premium.

## Authentication and Session Security

- Jetstream and Fortify use the `web` guard.
- Browser routes use Laravel authentication and Jetstream session middleware.
- Email verification is disabled intentionally; no `verified` middleware, verification route, or verification requirement is used.
- Password reset remains enabled through Fortify.
- Password creation, reset, and update flows hash passwords before persistence and enforce Fortify password rules.
- Blocked browser sessions are logged out, invalidated, and given a regenerated CSRF token.
- Session cookies are HTTP-only and SameSite `lax` by default. Production deployments must set `SESSION_SECURE_COOKIE=true` when served over HTTPS.
- Laravel's web middleware provides CSRF protection for state-changing browser routes.

## Authorization and Input Validation

- Domain controllers use policies for budgets, expenses, incomes, categories, savings goals, and related payments.
- Budget collaborators can view/update shared budgets, while only owners or administrators can delete or manage collaborators.
- Nested contribution/payment operations verify that the nested record belongs to the supplied parent model.
- Form Requests validate types, ranges, dates, plan values, category type, and category ownership.
- Eloquent models use explicit fillable attributes; relationship-owned foreign keys are supplied by the authenticated user or parent relation rather than trusted request input.
- Livewire components validate filter state and authorize every mount, render, and delete operation server-side.

## API and Sanctum

- Registration and login are rate-limited to 10 requests per minute.
- Protected API routes use `auth:sanctum`, account-status checks, and a 60 requests-per-minute throttle.
- Logout revokes the current token; logout-all revokes every token for the authenticated user.
- Blocked users cannot obtain new API tokens, and blocked existing tokens are revoked when used.
- API resources do not expose passwords, two-factor secrets, or account status.
- API controllers authorize model access and reject cross-user records.

## Database, SQL, and Output Safety

- User input is handled through Eloquent or parameterized query builder bindings.
- Raw SQL is limited to fixed, code-defined aggregate/date expressions; untrusted column names are not interpolated.
- Blade output uses escaped interpolation by default. No file-upload endpoint is currently implemented.
- Stripe credentials are read only from environment configuration and are not included in application responses, views, documentation, or SQL dumps.
- Stripe payment transactions use unique Stripe session/payment identifiers to prevent duplicate callback processing.

## Stripe

Checkout pricing remains unchanged: LKR 500 monthly and LKR 5000 yearly subscriptions. Checkout/API failures produce safe user-facing errors and technical server-side logs without secrets.

The success callback does not trust `session_id` by itself. Premium is granted only after Stripe confirms a completed, paid subscription session belonging to the authenticated user and matching the expected plan, product, amount, and currency. No webhook was added because the existing flow's minimum requirement is satisfied by server-side Checkout-session verification.

## Verification

Focused security validation:

`php artisan test tests/Feature/ExpenseTest.php tests/Feature/ApiAuditTest.php tests/Feature/BlockedMiddlewareTest.php`

Result: 21 tests passed, 60 assertions.

Stripe validation:

`php artisan test tests/Feature/StripeCheckoutTest.php tests/Feature/StripePaymentRegressionTest.php`

Result: 11 tests passed, 46 assertions.

The full application suite was run after the final security hardening and passed 82 tests with 221 assertions.

## SAFE

- Jetstream/Fortify authentication and password reset are active.
- Sanctum token revocation and ownership are enforced.
- Policies protect sensitive domain operations.
- CSRF, escaped Blade output, parameterized database access, rate limiting, and Stripe verification are active as described above.

## MINOR / Operational Notes

- Keep `APP_DEBUG=false` in production.
- Use HTTPS and set `SESSION_SECURE_COOKIE=true` in production.
- Supply real Stripe test/live keys only through deployment environment variables; never commit `.env`.
