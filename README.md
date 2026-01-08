## LaravelBackEnd — project README

This repository contains a small Laravel application built as a student project. It implements authentication, user profiles, a news system and a FAQ section. The app is developed to run in a local development environment using Herd (preferred) or PHP's built-in server.

Quick facts
- Dev host used during development: http://laravelbackend.test (Herd)
- Default seeded admin account (created by DatabaseSeeder):
	- Username: admin
	- Email: admin@ehb.be
	- Password: Password!321

Minimal setup (Herd)
1. Install Herd and add a site pointing to this project folder (the repository root). Set the host to `laravelbackend.test` and ensure your hosts file is configured by Herd.
2. Copy `.env.example` to `.env` and configure database/mail as needed.
3. Run composer install and npm install if you need assets:

```powershell
composer install
npm install
npm run build
```

4. Run migrations and seed the default admin:

```powershell
php artisan migrate --seed
```

5. Create the public storage symlink so uploaded images are served:

```powershell
php artisan storage:link
```

6. Open http://laravelbackend.test in your browser.

Alternative: quick test without Herd (PHP built-in server)

```powershell
php -S 127.0.0.1:8000 -t public
```

Mail configuration
------------------
Set the sender address and name so emails look correct. Add the following to your `.env` (or edit existing keys):

```
MAIL_MAILER=log        # use 'log' for development, change to smtp for real sending
MAIL_FROM_ADDRESS=no-reply@laravelbackend.test
MAIL_FROM_NAME="LaravelBackEnd"

# Optional: fallback admin e-mail if no admin user exists in the DB
ADMIN_EMAIL=admin@ehb.be
```

If you keep `MAIL_MAILER=log`, outgoing mails will be written to `storage/logs/laravel.log` — useful for development and for verifying the contact form behaviour.


Assignment checklist (current status)
- Login system: implemented (registration, login, logout, remember me, password reset, email verification) — COMPLETE
- User roles: `is_admin` boolean exists and default admin seeded — PARTIAL (you can promote/demote manually; no admin UI to manage roles yet)
- Profile page: implemented and editable by the user (username, birthday, bio, profile picture) — COMPLETE
- News: admins can create, edit, delete news items; public can list and view details — PARTIAL (create/edit routes exist and views exist; file uploads work; ensure migrations match column names) 
- FAQ: categories and Q/A implemented, admins can manage via routes/controllers — PARTIAL (basic CRUD exists, but no admin UI styling)
- Contact form: NOT YET IMPLEMENTED (the assignment requires an email to admin on contact form submit)
- Many-to-many relation: NOT YET IMPLEMENTED (assignment requests at least one many-to-many)

Technical checklist
- Views: multiple layouts present (`resources/views/layouts/app.blade.php` and `layouts/guest.blade.php`) — OK
- Components used for form inputs and buttons — OK
- CSRF protection: forms use `@csrf` — OK
- XSS: views escape content by default and use `e()` where needed — OK
- Routes: controllers are used; admin routes are grouped under `admin/*` — OK
- Migrations & seeders: present and `php artisan migrate --seed` should work — OK

What still needs to be done to meet the full assignment
- Implement contact form, Mailable to send admin an email and (optional) admin panel to view messages.
- Add at least one many-to-many relationship (suggestion: user favorites/news bookmarks) and small UI for it.
- Add an admin UI to promote/demote users and create users manually (or document how to do this via tinker/seeders).
- Add client-side validation for forms (basic JS) to meet the 'client-side validation' requirement.
- Improve README with source references you used for code snippets or tutorials (you must cite copied tutorial sections you used).

Sources / libraries used
- Laravel framework (see composer.json)
- Authentication scaffolding from Laravel Breeze (dev dependency)

If you want, I can implement the contact form + mail and the many-to-many favorite feature next (these are relatively small changes).

----

The original Laravel README follows below for reference.
