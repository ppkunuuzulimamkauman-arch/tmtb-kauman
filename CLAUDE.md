# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

- **Run tests:** `php artisan test`
- **Start development server:** `php artisan serve`
- **Compile assets:** `npm run dev` or `npm run build`
- **Run migrations:** `php artisan migrate`

## Codebase Architecture

This is a standard Laravel 10 application.

- **`app/`**: Contains core application logic, including models, controllers, and service classes.
- **`routes/`**: Defines application routes (web, api, console).
- **`resources/`**: Contains views (Blade templates), CSS, and JS assets.
- **`database/`**: Contains migrations and seeders for database management.
- **`tests/`**: Contains PHPUnit tests.
