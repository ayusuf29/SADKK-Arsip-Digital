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
-   **Note**: Ensure `DB_USERNAME` and `DB_PASSWORD` in `.env` match your XAMPP MySQL credentials.
    -   Default XAMPP Username: `root`
    -   Default XAMPP Password: (empty)
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sadkk_banksulteng
    DB_USERNAME=root
    DB_PASSWORD=
    ```

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
| **Surat** | `documents` | Unified table for docs (Type: surat, Jenis: masuk/keluar) |
| **Invoice** | `documents` | Unified table for docs (Type: invoice, Jenis: masuk/keluar) |
| **Perjanjian Kredit** | `documents` | Unified table for docs (Type: kredit) |
| **User Management** | `users` | Admin user management, Profile password change |

## 6. How to Run (Development)

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
    git commit -m "Initial commit..."
    ```

## 8. Running on XAMPP (Apache Production-like)

To run the application using XAMPP's Apache server instead of `php artisan serve`, follow these steps:

### Method A: Virtual Host (Recommended)
This method allows you to access the app via a custom domain (e.g., `http://sadkk.local`) without moving the project folder.

1.  **Enable Virtual Hosts in Apache**:
    -   Open `C:\xampp\apache\conf\httpd.conf` (or wherever XAMPP is installed).
    -   Uncomment (remove `#`) the line: `Include conf/extra/httpd-vhosts.conf`.

2.  **Configure the Virtual Host**:
    -   Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`.
    -   Add the following configuration:
        ```apache
        <VirtualHost *:80>
            DocumentRoot "D:/project/php/sadkk-banksulteng/sadkk/public"
            ServerName sadkk.local
            <Directory "D:/project/php/sadkk-banksulteng/sadkk/public">
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
            </Directory>
        </VirtualHost>
        ```

3.  **Update Windows Hosts File**:
    -   Run Notepad as Administrator.
    -   Open `C:\Windows\System32\drivers\etc\hosts`.
    -   Add this line at the bottom:
        ```
        127.0.0.1 sadkk.local
        ```

4.  **Restart Apache**:
    -   Stop and Start Apache via the XAMPP Control Panel.

5.  **Update .env**:
    -   Open `.env` in the project root.
    -   Change `APP_URL` to:
        ```
        APP_URL=http://sadkk.local
        ```

### Method B: Access via Subdirectory (Easiest)
If you don't want to set up a Virtual Host, you can access it via `localhost`.

1.  **Create a Symlink** (Recommended over copying):
    -   Open Command Prompt as Administrator.
    -   Run:
        ```cmd
        mklink /J "C:\xampp\htdocs\sadkk" "D:\project\php\sadkk-banksulteng\sadkk"
        ```
    -   *Note: Adjust `C:\xampp\htdocs` to your actual XAMPP path.*

2.  **Access in Browser**:
    -   Go to: `http://localhost/sadkk/public`

3.  **Update .env**:
    -   Change `APP_URL=http://localhost/sadkk/public`
