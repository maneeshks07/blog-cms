# Blog CMS

A responsive content management system for creating, managing, and publishing blog posts. The project includes an authenticated admin dashboard, post CRUD operations, draft/published workflow, public post pages, search, category filtering, and dashboard statistics.

## Features

- Admin authentication with password hashing
- Dashboard with post/category statistics
- Create, edit, publish, and delete posts
- Draft and published post status
- Public blog listing and individual post pages
- Search and category filtering
- Prepared MySQL statements for database operations
- Responsive interface with reusable PHP partials

## Tech Stack

- PHP
- MySQL
- MySQLi prepared statements
- HTML5
- CSS3
- JavaScript

## Local Setup

This project is designed for XAMPP, WAMP, or Laragon.

1. Copy the project folder into your local web server directory (`htdocs` for XAMPP or `www` for WAMP/Laragon).
2. Start Apache and MySQL.
3. Open phpMyAdmin and import `database.sql`. The script creates the `blog_cms` database and demo data.
4. If your MySQL credentials differ from the local default, update `includes/connection.php`.
5. Open `http://localhost/03-blog-cms/login.php` in your browser.

### Demo Login

- Username: `admin`
- Password: `admin123`

## Project Structure

```text
blog-cms/
├── css/                 # Shared blog/admin styles
├── includes/            # Database connection, auth, and data logic
├── database.sql         # Database schema and demo content
├── dashboard.php        # Admin dashboard
├── manage.php           # Post management
├── form.php             # Create/edit post form
├── index.php            # Public blog listing
├── post.php             # Public post page
├── login.php            # Admin login
└── README.md
```

## Portfolio Notes

This project demonstrates practical PHP/MySQL development, authentication, CRUD workflows, prepared statements, reusable components, and responsive UI implementation.
