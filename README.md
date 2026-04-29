# Bibliotheca — Smart Library Management System

> A full-stack library management system built with Laravel, featuring dual-role authentication (Admin / Client), book loan tracking, and automated backup support.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Templates-orange?style=flat-square)
![Vite](https://img.shields.io/badge/Vite-Frontend-646CFF?style=flat-square&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)
![Release](https://img.shields.io/badge/Release-v1.1.0-blue?style=flat-square)

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Architecture](#architecture)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Test Credentials](#test-credentials)
- [Project Structure](#project-structure)
- [Backup System](#backup-system)
- [Roadmap](#roadmap)
- [Contributing](#contributing)

---

## Overview

**Bibliotheca** is a web-based library management platform designed to streamline the day-to-day operations of a library. It provides two distinct interfaces: an **Admin panel** for librarians to manage the full catalog and user activity, and a **Client portal** for members to browse available books and track their loan history.

The application follows Laravel's MVC conventions with clearly separated routing and controller namespaces for each role, ensuring clean isolation between admin and client concerns.

---

## Features

### Admin Panel
- Full CRUD management for books, authors, and categories
- Member management and loan approval workflow
- Global loan history and overdue tracking
- Dashboard with key library statistics

### Client Portal
- Secure client authentication (isolated from admin)
- Browse and search the available book catalog
- Personal loan history and active loans overview
- Individual reading statistics dashboard

### System
- Automated timestamped backups (`backups/backup_client_YYYYMMDD_HHmmss/`)
- `.env`-driven configuration for easy environment switching
- PHPUnit test suite scaffolded and ready to extend
- Vite-powered frontend asset pipeline

---

## Architecture

```
┌─────────────────────────────────────────────────────┐
│                   Laravel Application                │
│                                                     │
│  ┌──────────────────┐    ┌────────────────────────┐ │
│  │   Admin Panel    │    │    Client Portal       │ │
│  │                  │    │                        │ │
│  │  /admin/*        │    │  /client/*             │ │
│  │  AdminController │    │  Client/Auth/*         │ │
│  │  (full CRUD)     │    │  Client/Dashboard      │ │
│  └──────────────────┘    └────────────────────────┘ │
│                                                     │
│  ┌──────────────────────────────────────────────┐   │
│  │              Shared Layer                    │   │
│  │  Models · Migrations · Seeders · Policies    │   │
│  └──────────────────────────────────────────────┘   │
│                                                     │
│  ┌──────────────────────────────────────────────┐   │
│  │         Frontend (Blade + Vite)              │   │
│  │  Admin layout  │  Client layout (green sidebar)  │
│  └──────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────┘
```

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.x, Laravel 10.x |
| Templating | Blade |
| Frontend Build | Vite |
| Database | MySQL / SQLite (configurable) |
| Auth | Laravel Breeze / custom guards |
| Testing | PHPUnit |
| Package Manager | Composer, npm |

---

## Prerequisites

Ensure the following are installed on your machine:

- PHP >= 8.1
- Composer >= 2.x
- Node.js >= 18.x & npm
- MySQL 8.x (or SQLite for local development)
- Git

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/ouhaddousara/Bibliotheca.git
cd Bibliotheca

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy the environment file
cp .env.example .env

# 5. Generate the application key
php artisan key:generate
```

---

## Configuration

Edit the `.env` file with your local database credentials:

```dotenv
APP_NAME="Gestion Bibliothèque"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_bibliotheque
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run migrations and seed the database:

```bash
# Run migrations
php artisan migrate

# (Optional) Seed with sample data
php artisan db:seed
```

---

## Running the Application

Open two terminal windows and run both simultaneously:

```bash
# Terminal 1 — Laravel development server
php artisan serve

# Terminal 2 — Vite asset watcher
npm run dev
```

The application will be available at `http://localhost:8000`.

---

## Test Credentials

| Role | Email | Password |
|---|---|---|
| Client | client@test.fr | client.2026 |
| Admin | *(configure via seeder or manually)* | — |

> ⚠️ These credentials are for local development only. Change them before any deployment.

---

## Project Structure

```
Bibliotheca/
├── app/
│   └── Http/
│       └── Controllers/
│           ├── Admin/          # Admin-side controllers
│           └── Client/         # Client-side controllers
│               └── Auth/       # Client authentication
├── backups/                    # Automated timestamped backups
├── config/                     # Laravel configuration files
├── database/
│   ├── migrations/             # Database schema
│   └── seeders/                # Sample data seeders
├── public/                     # Web root (assets, index.php)
├── resources/
│   └── views/
│       ├── admin/              # Admin Blade templates
│       └── client/             # Client Blade templates
│           └── layouts/        # Client app layout (green sidebar)
├── routes/
│   ├── web.php                 # Shared routes
│   ├── admin.php               # Admin-only routes
│   └── client.php              # Client-only routes
├── storage/                    # Logs, cache, uploaded files
├── tests/                      # PHPUnit feature & unit tests
├── .env.example                # Environment template
├── composer.json
├── package.json
└── vite.config.js
```

---

## Backup System

The project includes an automated backup mechanism that snapshots the client module state at key development checkpoints. Backups are stored under:

```
backups/backup_client_YYYYMMDD_HHmmss/
```

This allows safe rollback when iterating on the client portal without affecting the stable admin module.

---

## Roadmap

- [ ] Client book browsing with search and filters
- [ ] Loan request and approval workflow
- [ ] Personal reading statistics for clients
- [ ] Email notifications for due dates
- [ ] REST API layer for mobile client support
- [ ] Docker + docker-compose for reproducible environments
- [ ] CI/CD pipeline via GitHub Actions
- [ ] Role-based access control (RBAC) refinement

---

## Contributing

Contributions are welcome. Please follow the standard GitHub flow:

```bash
# Create a feature branch
git checkout -b feature/your-feature-name

# Commit your changes with a clear message
git commit -m "feat: add book search with filters"

# Push and open a Pull Request
git push origin feature/your-feature-name
```

Please ensure all existing tests pass before opening a PR:

```bash
php artisan test
```
