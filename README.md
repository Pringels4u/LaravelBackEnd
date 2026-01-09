
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
- In deze repository zijn (nog) geen automatische feature-tests opgenomen in de codebase. Hieronder vind je drie concrete, reproduceerbare test-cases die je kunt implementeren met PHPUnit / Laravel's test helpers. Voeg ze toe onder `tests/Feature/` (bijv. `ContactTest`, `NewsAdminTest`, `NewsInteractionTest`) en voer ze lokaal uit met `php artisan test`.

Aanbevolen testcases (specificaties)
1) Contactformulier (tests/Feature/ContactTest.php)
   - Doel: verifiëren dat een ingevuld contactformulier een record in de database creëert en dat er een e-mail wordt gegenereerd/logged.
   - Setup: geen authenticatie vereist.
   - Stappen:
     1. POST naar route `contact.store` met geldige velden (name, email, message).
     2. Assert: response redirect met success flash.
     3. Assert: een record bestaat in `contact_messages` met dezelfde inhoud.
     4. Assert: Mail is gelogd of Mailable is verzonden (gebruik `Mail::fake()` en `Mail::assertSent(ContactFormSubmitted::class)`).

2) News CRUD (tests/Feature/NewsAdminTest.php)
   - Doel: controleren dat een admin nieuws kan aanmaken en dat het zichtbaar is op de publieke index.
   - Setup: maak een gebruiker met `is_admin = true` (factory of rechtstreeks aanmaken) en log in als die user.
   - Stappen:
     1. POST naar admin nieuws store-route met titel, content en published_at.
     2. Assert: redirect naar admin index met success.
     3. Assert: database bevat het nieuws item.
     4. GET naar `news.index` en assert dat titel zichtbaar is in de response.

3) Favorieten & comments (tests/Feature/NewsInteractionTest.php)
   - Doel: verifiëren dat geauthenticeerde gebruikers een nieuwsitem kunnen favoriet zetten/ontzetten en een reactie kunnen plaatsen.
   - Setup: maak een gebruiker en een nieuwsitem (factories), log in.
   - Stappen:
     1. POST naar favorite toggle-route en assert dat de pivot `news_user` een entry bevat.
     2. POST naar comments store-route met content en assert dat `news_comments` een record bevat.
     3. Optioneel: toggle favorite opnieuw en assert dat de pivot entry verdwenen is.

Hoe tests lokaal uit te voeren
1. Zorg dat je test-database ingesteld is in `.env.testing` of gebruik sqlite in memory door in `.env.testing` te zetten:

```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

2. Voer de tests uit met:

```powershell
php artisan test
# of direct met phpunit
vendor\bin\phpunit
```

3. Tijdens het schrijven van tests kun je helpers zoals `Mail::fake()` en `Storage::fake('public')` gebruiken om side-effects te isoleren.

Als je wil, kan ik deze drie testbestanden nu voor je aanmaken en direkt uitvoeren (ik schrijf ze in `tests/Feature/` en run `php artisan test`). Zeg of ik dat direct moet doen en of je wilt dat ik factories/mocks gebruik of echte seed-data.

Bronvermelding
- Laravel documentatie — https://laravel.com/docs
- Gebruikte packages en scaffolding: controllers en views voor authenticatie staan onder `app/Http/Controllers/Auth` en `resources/views/auth` — als je een externe tutorial of package (bv. Laravel Breeze) hebt gebruikt, vermeld dat hier expliciet.
- UI: Tailwind CSS (indien gebruikt) — https://tailwindcss.com
- Laravel Feature Testing: https://laravel.com/docs/testing
- Laravel Eloquent Relationships & Pivot Tables: https://laravel.com/docs/eloquent-relationships

- Heb copilot Alleen gebruikt op het einde om te zien of ik alle features geimplementeerd had
