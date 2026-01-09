
# LaravelBackEnd — Chiro Lembeek demo application

This is a small Laravel application implemented as a student project and themed for "Chiro Lembeek". It demonstrates common web-app features used in the assignment:

- Authentication (registration, login, password reset, email verification)
- User profiles (username, birthday, bio, profile picture)
- News items (admin CRUD, public listing and detail pages)
- FAQ section with categories (admin CRUD)
- Contact form (messages saved and mailed to admin; in development mails are logged)
- News favorites (many-to-many pivot)
- News comments (authenticated users can comment on news items)

Quick facts
- Dev host used during development: http://laravelbackend.test (Herd recommended)
- Default seeded admin account (created by DatabaseSeeder):
	- Username: admin
	- Email: admin@ehb.be
	- Password: Password!321

This project contains some theme and UI polish for "Chiro Lembeek": the app name is set accordingly and the dashboard, navigation and seed data were updated to reflect the theme.

Getting started (minimal)
1. Copy `.env.example` to `.env` and configure your DB and mail settings.
2. Install PHP dependencies:

```powershell
composer install
```

3. (Optional) Install Node dependencies and build assets if you want Tailwind-based styling:

```powershell
npm install
# for development
npm run dev
# or for production
npm run build
```

4. Run migrations and seed sample data:

```powershell
php artisan migrate --seed
# or to reset completely:
php artisan migrate:fresh --seed
```

5. Make the storage symlink so uploaded images are served:

```powershell
php artisan storage:link
```

6. Start the site (Herd or built-in server):

```powershell
# Herd: point site to project root and use http://laravelbackend.test
# Built-in PHP server (quick alternative)
php -S 127.0.0.1:8000 -t public
```

Mail configuration (development)
Add or change the following in your `.env`:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=no-reply@chirolembeek.test
MAIL_FROM_NAME="Chiro Lembeek"
```

When using `MAIL_MAILER=log` outgoing messages are written to `storage/logs/laravel.log` which is handy for development and verifying the contact flow.

Data seeded by the project
- A default admin user is created when seeding. The seeder is idempotent and will not fail if the admin already exists.
- Sample FAQ categories and items are seeded (theme: Chiro Lembeek).
- Sample news items are seeded so the dashboard and news index show content immediately.

Key features implemented
- Public dashboard: the dashboard is accessible to guests and includes a themed hero, quick actions, upcoming activities, recent news and FAQ snippets.
- News comments: authenticated users can leave comments on news detail pages; comments are visible on the news details page.
- Admin features: under `/admin` (protected by auth + admin middleware)
	- News CRUD (create / edit / delete)
	- FAQ CRUD
	- Manage users: list, create users manually, promote/demote admin
	- View contact messages
- Favorites: logged-in users can favorite news items (many-to-many pivot table).

Routes of interest
- Public
	- GET /news — news index
	- GET /news/{newsItem} — news detail (shows comments)
	- POST /news/{newsItem}/comments — store comment (requires auth)
	- GET /faq — FAQ index
	- GET /contact — contact form
	- POST /contact — submit contact message

- Admin (prefix `/admin`, auth + admin middleware)
	- /admin/news — admin news routes (resource controller minus index/show)
	- /admin/faq — admin FAQ routes
	- /admin/users — list/create/store and toggle admin
	- /admin/contacts — view contact messages

Troubleshooting
- If you see missing styling, ensure frontend assets are built with `npm run dev` or `npm run build` and that `@vite` in `resources/views/layouts/app.blade.php` points to the built files.
- If a seeder fails with unique constraint errors, re-run `php artisan migrate:fresh --seed` to reset the DB (be careful: this drops data).

Testing and next steps
- Tests: basic feature tests are not yet written; recommended tests to add:
	1. Contact form submission stores message and logs mail
	2. Admin can create news and it appears on the index
	3. Authenticated user can favorite a news item and toggle the favorite
	4. Authenticated user can post a comment and see it on the news detail

- Possible enhancements:
	- Add moderation (edit/delete) for comments by admins
	- Paginate comments on news pages
	- Convert inline fallback styles to proper Tailwind classes and rebuild assets

If you want, I can add the feature tests next or implement comment moderation — tell me which one you'd prefer and I'll add it to the TODOs.

----

Original project README (trimmed) — kept for reference.
