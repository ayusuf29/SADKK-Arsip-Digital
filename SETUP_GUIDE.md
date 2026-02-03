# Setup Guide: Sistem Arsip Digital Koperasi Karyawan Bank Sulteng

This document outlines the step-by-step process used to set up the **Sistem Arsip Digital Koperasi Karyawan Bank Sulteng** project.

## 1. Environment & Project Initialization

### 1.1. Requirements
- **PHP**: 8.3 (Local toolchain used)
- **Composer**: 2.x
- **Database**: MySQL (via XAMPP)
- **Framework**: Laravel 12

### 1.2. Project Creation
The project was created using Laravel 12:
```bash
composer create-project laravel/laravel sadkk
```
*App Name configured in `.env`: "Sistem Arsip Digital Koperasi Karyawan Bank Sulteng"*

## 2. AdminLTE Integration

We used the `jeroennoten/laravel-adminlte` package for the admin dashboard.

1.  **Installation**:
    ```bash
    composer require jeroennoten/laravel-adminlte
    php artisan adminlte:install
    ```
2.  **Configuration**:
    -   Modified `config/adminlte.php` to customize the title, logo, and sidebar menu.
    -   Added links for: Dashboard, Surat Masuk/Keluar, Invoice Masuk/Keluar, Perjanjian Kredit, and Manajemen User.

## 3. Database & Authentication Setup

### 3.1. Database Configuration
-   Updated `.env` to connect to the local XAMPP MySQL database `sadkk_banksulteng`.

### 3.2. Custom Authentication (Username)
-   **Migration**: Modified the `users` table migration to include a `username` column and make `email` nullable.
-   **Login Controller**: Overrode the `username()` method in `App\Http\Controllers\Auth\LoginController` to authenticate using `username` instead of `email`.
-   **Views**: Updated `resources/views/auth/login.blade.php` to display a "Username" input field.

### 3.3. Seeding
-   Created `AdminUserSeeder` to create a default administrator account.
    -   **Username**: `admin`
    -   **Password**: `password`

## 4. Application Architecture (Repository Pattern)

To ensure clean code and separation of concerns, we implemented the Repository Pattern.

### 4.1. Structure
-   **Interfaces**: Located in `app/Repositories/Interfaces`
-   **Implementations**: Located in `app/Repositories/Implementations`
-   **Service Provider**: `App\Providers\RepositoryServiceProvider` binds interfaces to implementations.

### 4.2. Modules Created
For each module (Surat, Invoice, PerjanjianKredit, User), we created:
1.  **Model**: Eloquent model with migration.
2.  **Migration**: Defined table schema (e.g., `nomor_surat`, `plafon`, etc.).
3.  **Repository Interface**: Defined standard CRUD methods (`all`, `find`, `create`, `update`, `delete`).
4.  **Repository Implementation**: Implemented the interface using Eloquent.
5.  **Controller**: Resource controller ready to use the repository.
6.  **Route**: Defined resource routes in `routes/web.php` under the `admin.` prefix.

## 5. Summary of Modules

| Module | Table Name | Key Features |
| :--- | :--- | :--- |
| **Surat** | `surats` | Incoming/Outgoing letters, file attachment |
| **Invoice** | `invoices` | Client name, amount, status (paid/unpaid) |
| **Perjanjian Kredit** | `perjanjian_kredits` | Debtor name, ceiling (plafon), term (jangka waktu) |
| **User Management** | `users` | Admin user management |

## 6. How to Run

1.  **Start Database**: Ensure XAMPP MySQL is running.
2.  **Run Migrations & Seed**:
    ```bash
    php artisan migrate --seed
    ```
3.  **Start Server**:
    ```bash
    php artisan serve
    ```
4.  **Login**: Access `http://127.0.0.1:8000/login`
    -   User: `admin`
    -   Pass: `password`

## 7. Version Control Setup

1.  **Git Installation**:
    -   Downloaded and installed MinGit (Portable) to `d:\project\php\tools\git`.
    -   Added Git binary to system PATH.

2.  **Initialization**:
    ```bash
    git init
    git config user.name "SADKK Developer"
    git config user.email "dev@sadkk.local"
    git add .
    git commit -m "Initial commit: Laravel 12 AdminLTE setup with Repository Pattern"
    ```
