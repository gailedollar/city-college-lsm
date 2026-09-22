# City College Learning Module System

A Laravel 13 front-end prototype for City College of Cagayan de Oro. It includes separate Student, Teacher, and Administrator dashboard previews with a shared responsive Blade layout.

## Development environment

- PHP 8.5 and Composer
- Node.js and npm
- Laravel 13
- `APP_ENV=local` and `APP_DEBUG=true` for preview routes

## Install and run

```sh
composer install
cp .env.example .env
php artisan key:generate
npm install
```

In separate terminals, run:

```sh
php artisan serve
npm run dev
```

You can use `npm run build` to compile assets for a non-Vite development server. The existing `/login` page remains a front-end form; authentication is not implemented yet.

## Local dashboard previews

With `APP_ENV=local` and `APP_DEBUG=true`:

- Student: http://127.0.0.1:8000/dev/student
- Teacher: http://127.0.0.1:8000/dev/teacher
- Administrator: http://127.0.0.1:8000/dev/admin

The Student portal shows subjects, modules, assignments, progress, materials, deadlines, and announcements. The Teacher portal shows classes, published modules, students, submissions, activities, and notices. The Administrator portal shows campus counts, registrations, activity, and academic announcements.

These pages contain fictional demonstration data and are not authenticated sessions. The preview routes are registered only when the environment is local and debug mode is enabled. The existing `/dashboard` route remains protected by authentication. Sidebar sections marked “Coming soon” have no destination yet.

Authentication, role permissions, and MySQL database integration are future milestones.
