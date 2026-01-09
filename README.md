
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

Getting started (Herd — recommended)

This project is intended to be run with Herd for development and evaluation. If your teacher will run the project with Herd, follow these minimal steps:

1. Copy `.env.example` to `.env` and configure your DB and mail settings if you want to change them.
# LaravelBackEnd — Chiro Lembeek studentproject

Een overzichtelijke Laravel-demoapplicatie gemaakt als studentproject, gethematiseerd rond "Chiro Lembeek". De app bevat alle functionele minimumvereisten voor het examenproject (authenticatie, profielen, nieuws, FAQ, contact) en enkele extra's (favorieten, reacties, admin-overzicht voor contactberichten).

Inhoudelijk overzicht
- Authenticatie (registratie, login, wachtwoord-reset, e-mailverificatie)
- Publieke profielpagina's met username, verjaardag, bio en profielfoto
- Nieuwsitems: admin CRUD, publieke index en detailpagina
- FAQ: categorieën met vraag/antwoord, admin CRUD
- Contactformulier: berichten worden opgeslagen en naar de eerste admin gemaild
- Extra: nieuws-favorieten (many-to-many pivot) en nieuwsreacties (comments)

Quick facts
- Development host gebruikt bij ontwikkeling: http://laravelbackend.test (Herd aanbevolen)
- Standaard seeded admin-account (DatabaseSeeder):
  - Username: admin
  - Email: admin@ehb.be
  - Password: Password!321

Benodigde software
- PHP (8.1+ aanbevolen, afhankelijk van je Composer packages)
- Composer
- Een database (MySQL, MariaDB, SQLite, ...)
- Optioneel: Herd voor eenvoudiger lokale hosting, of `php artisan serve`/built-in PHP server

Installatie en lokaal draaien (PowerShell)
1. Kopieer `.env.example` naar `.env` en configureer je database- en mailinstellingen.

```powershell
composer install
cp .env.example .env
php artisan key:generate
```

2. Database migreren en seeders uitvoeren:

```powershell
php artisan migrate --seed
```

3. Maak de public storage link zodat geüploade afbeeldingen beschikbaar zijn:

```powershell
php artisan storage:link
```

4. Start de ontwikkelserver (of gebruik Herd):

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Mail configuratie (ontwikkeling)
Pas in `.env` de volgende waarden aan om mails te loggen in plaats van echt te versturen:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=no-reply@chirolembeek.test
MAIL_FROM_NAME="Chiro Lembeek"
```

Wanneer `MAIL_MAILER=log` staat, worden uitgaande mails weggeschreven naar `storage/logs/laravel.log`.

Belangrijke routes (kort)
- Public
  - GET /news — nieuwsindex
  - GET /news/{newsItem} — nieuwsdetail (reacties zichtbaar)
  - GET /faq — FAQ overzicht
  - GET /contact — contactformulier
  - POST /contact — submit contactbericht
- Admin (prefix `/admin`, beschermd door `auth` + `admin` middleware)
  - /admin/news — nieuws CRUD (create/edit/delete)
  - /admin/faq — FAQ CRUD
  - /admin/users — gebruikersbeheer (aanmaken, promoten/demoten)
  - /admin/contacts — overzicht contactberichten

Technische highlights
- Views: meerdere layouts aanwezig (`resources/views/layouts/app.blade.php`, `guest.blade.php`) en Blade components worden gebruikt (x-app-layout e.d.).
- CSRF/XSS: Blade escaping en `@csrf` in formulieren toegepast.
- Models & relaties: Eloquent-modellen per entiteit, met minimaal één one-to-many (Category -> FaqItem) en één many-to-many (User <-> NewsItem).

Seeding
- `DatabaseSeeder` maakt idempotent de standaard admin aan en roept `FaqSeeder` en `NewsSeeder` aan zodat de site direct content toont.

Tests
- Er zijn nog geen uitgebreide feature-tests toegevoegd. Aanbevolen tests om toe te voegen:
  1. Contactformulier: controleer dat bericht opgeslagen wordt en mail gelogd wordt.
  2. News CRUD: admin kan nieuws aanmaken en het verschijnt op de index.
  3. Favorieten & comments: geauthende gebruiker kan favorieten togglen en een reactie plaatsen.

Bronvermelding
- Laravel documentatie — https://laravel.com/docs
- Gebruikte packages en scaffolding: controllers en views voor authenticatie staan onder `app/Http/Controllers/Auth` en `resources/views/auth` — als je een externe tutorial of package (bv. Laravel Breeze) hebt gebruikt, vermeld dat hier expliciet.
- UI: Tailwind CSS (indien gebruikt) — https://tailwindcss.com

Aanbevelingen / bekende verbeterpunten
- Voeg enkele feature-tests toe om regressies te voorkomen.
- Verwijder geüploade afbeeldingen bij verwijderen van een gebruiker (cleanup) — momenteel wordt profielfoto opschonen niet expliciet gedaan.
- Overweeg paginatie op de nieuwsindex en voor reacties wanneer veel items aanwezig zijn.
- Overweeg het mailable `ContactFormSubmitted` queueable te maken voor betere performance bij veel verkeer.

Contact / inleveren
- Zorg dat je GitHub-repo publiek toegankelijk is en geef de link als comment bij je inlevering. De docent zal `git clone <url>` uitvoeren.

Als je wil kan ik nu:
- De README verder toespitsen op jouw exacte gebruikte packages (zeg welke je gebruikte),
- 3 korte feature-tests schrijven en runnen, of
- File-cleanup implementeren bij user-delete.
Kies één taak en ik voer het meteen uit.
