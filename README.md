# Assistance Request Tracking System

A beginner-friendly PHP 8 and MySQL application for recording and tracking requests for assistance.

## Requirements

- XAMPP with Apache, PHP 8+, MySQL, and phpMyAdmin
- A browser

## XAMPP setup

1. Place this folder at `C:\xampp\htdocs\ARTS`.
2. Start Apache and MySQL in the XAMPP Control Panel.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Import `database/database.sql`.
5. Import `database/sample_data.sql` if you want sample records.
6. Visit `http://localhost/ARTS/public/`.

The default login is:

- Username: `admin`
- Password: `password`

You can also select **Create an account** on the login page to register another staff account.

If your MySQL root account has a password, update `config/database.php`.

## How it works

```text
User
  ↓
PHP Form
  ↓
PHP
  ↓
MySQL
  ↓
phpMyAdmin
  ↓
Requests Page
```

A staff member submits an HTML form. PHP validates the POST values, uses a PDO prepared statement to save them in MySQL, and then the saved record can be viewed both in phpMyAdmin and in the Requests page.

## Folder structure

- `config/` contains the shared database connection.
- `public/` contains pages that users open in their browser.
- `inc/` contains authentication, layout, validation, and helper files.
- `database/` contains SQL setup and fictional sample data.

## Request ID

New requests receive IDs such as `REQ-2026-0006`. The number is based on the next database record ID.

## Security basics

The application uses sessions, password hashing, password verification, CSRF tokens for POST forms, prepared statements, output escaping, and server-side validation.
