# VIDYA

VIDYA is a PHP-based note management system designed for educational use. It supports student and teacher uploads, admin oversight, and downloadable study materials through a MySQL-backed web application.

## Features

- Student and teacher registration and login
- Teacher note uploads
- Browseable note gallery
- Admin dashboard for user and note management
- Teacher profile management
- Download tracking for uploaded notes
- Feedback submission
- Session-based PHP authentication

## Tech Stack

- PHP
- MySQL
- HTML
- CSS
- JavaScript

## Project Structure

- `admin_dash.php` – admin dashboard
- `admin_login.php` – admin login page
- `approve_notes.php` – note approval dashboard
- `browse_notes.php` – browse uploaded notes
- `download_note.php` – note download and tracking
- `manage_students.php` – student management
- `manage_teachers.php` – teacher management
- `teacher_profile.php` – teacher profile page
- `upload.php` – note upload page
- `user_reg.php` / `user_regcode.php` – registration flow
- `userlogin.php` / `user_logincode.php` – login flow
- `homepage.php` – landing page
- `header.php`, `footer.php` – layout components

## Setup

1. Place the project in a PHP-enabled web server directory.
2. Create a MySQL database for the app.
3. Update the database configuration in the PHP files to match your environment.
4. Start the PHP server or configure Apache.
5. Open the project in your browser.

Example local run:

```bash
php -S localhost:8000
```

Then open:

```text
http://localhost:8000/homepage.php
```

## Notes

This project is a simple academic portal for note sharing and administration. It may require database table creation and local environment configuration before use.

## License

This project is licensed under the MIT License. See `LICENSE` for details.
VIDYA – Note Gallery with student &amp; teacher uploads, admin management, and download tracking using PHP and MySQL.
