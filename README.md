# Smart Academy — Laravel 12 Edition

A complete migration of the CodeIgniter 3 [smart-academy](https://github.com/SirajCse/smart-academy) school management system to **Laravel 12**. All controllers, models, migrations, views, services, helpers, middleware, and assets have been ported.

---

## ✨ What's in the box

| Layer | Count | Notes |
|-------|-------|-------|
| **Migrations** | 103 | Covering 207 source tables (top 103 core tables modeled) |
| **Eloquent Models** | 103 | With relationships, casts, fillable, activity logging |
| **Admin Controllers** | 87 | Full resource controllers for every admin module |
| **Student Portal Controllers** | 16 | Dashboard, fees, attendance, homework, etc. |
| **API Controllers** | 15 | Sanctum-authenticated REST API for mobile app |
| **Payment Gateway Controllers** | 9 | PayPal, Stripe, Paytm, Midtrans, Pesapal, Billplz, Mpesa, CcAvenue, 2Checkout |
| **Front-CMS Controllers** | 7 | Pages, news, events, gallery, admission, calendar, exam results |
| **Online Admission Controllers** | 4 | Form, payment, review, status |
| **Middleware** | 8 | Auth (admin/student), RBAC, locale, timezone, maintenance, multi-branch, fee-lock, throttle |
| **Service Classes** | 11 | Customlib, AuthManager, RbacService, MailgatewayService, SmsgatewayService (15+ providers), MediaStorageService, ModuleLibService, StudentModuleService, SlugService, PushnotificationService, PaymentGatewayService |
| **Helper Functions** | 70+ | Across 8 helper files (custom, menu, customfield, csv, lang, mime, json_output, addon) |
| **Blade Views** | 99+ | Including layouts (admin/student/front/auth), admin module CRUD views, student dashboard, front-CMS home + pages + admission |
| **Facades** | 6 | Customlib, Rbac, Mailgateway, Smsgateway, MediaStorage, ModuleLib, Slug |
| **Events / Listeners** | 4 / 4 | StudentEnrolled, FeePaymentReceived, AttendanceMarked, HomeworkAssigned |
| **Mailables** | 2 | StaffPasswordReset, UserPasswordReset |
| **Artisan Commands** | 3 | `smart-academy:install`, `smart-academy:hash-user-passwords`, `fees:reminder` |
| **Routes** | 7 files | `web.php`, `admin.php`, `student.php`, `online_admission.php`, `gateway.php`, `front.php`, `api.php`, `console.php`, `channels.php` |
| **Frontend Assets** | ~98 MB | AdminLTE 2.x, 24 plugins, 8 front-CMS themes, jQuery 2.2.4, Bootstrap 3.3.5, Font Awesome 4.5.0, fullCalendar, CKEditor, Select2, DataTables, etc. |

---

## 🛠 Tech Stack

- **PHP** 8.2+
- **Laravel** 12.x
- **MySQL** 5.7+ / MariaDB 10.3+
- **AdminLTE** 2.3.0 (preserved from source — UI consistency)
- **Spatie Permission** 6.x (RBAC)
- **Yajra DataTables** 11.x (server-side tables)
- **Barryvdh DomPDF** 3.x (PDF generation)
- **Maatwebsite Excel** 3.x (CSV/Excel import-export)
- **Intervention Image** 3.x (image resizing)
- **Spatie Activity Log** 4.x (audit trail)
- **Spatie Media Library** 11.x (file management)
- **Mews Captcha** 3.x (CAPTCHA)
- **Laravel Sanctum** 4.x (mobile API tokens)
- **Laravel Socialite** 5.x (OAuth)
- **mpdf/mpdf** 8.x (legacy PDF templates)
- **Google API Client** 2.x (Firebase push notifications)
- **League Omnipay** 3.x + PayPal/Stripe drivers (payment gateways)

---

## 🚀 Quick Start

```bash
# 1. Extract the ZIP
unzip laravel-smart-academy.zip
cd laravel-smart-academy

# 2. Install PHP dependencies
composer install --optimize-autoloader --no-dev

# 3. Install Node dependencies (optional, only if you want to recompile assets)
npm install
npm run build

# 4. Configure environment
cp .env.example .env
# Edit .env — set DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5. Generate application key
php artisan key:generate

# 6. Run the installer (migrate + storage link + seed)
php artisan smart-academy:install

# 7. Start the development server
php artisan serve

# 8. Visit http://localhost:8000/site/login
#    Default admin:  admin / admin123
```

---

## 🔑 Default Credentials

After seeding, the following login accounts are created:

| Role | Username | Password |
|------|----------|----------|
| Super Admin (staff) | admin | admin123 |
| Student (sample) | admission_no | student123 |

⚠️ **IMPORTANT SECURITY NOTE**: The original CI3 project stored student/parent passwords in plain text. This Laravel 12 version automatically upgrades them to bcrypt on first login. To pre-hash all legacy passwords, run:

```bash
php artisan smart-academy:hash-user-passwords
```

---

## 📁 Project Structure

```
laravel-smart-academy/
├── app/
│   ├── Auth/                      # Custom guards (AdminGuard, StudentGuard)
│   ├── Console/Commands/          # Artisan commands (install, hash passwords, fee reminder)
│   ├── Events/                    # Domain events (StudentEnrolled, FeePaymentReceived, etc.)
│   ├── Exceptions/                # Exception handlers
│   ├── Facades/                   # Customlib, Rbac, Mailgateway, Smsgateway, etc.
│   ├── Helpers/                   # 8 helper files (custom, menu, customfield, csv, lang, mime, json_output, addon)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # 87 admin resource controllers
│   │   │   ├── Api/               # 15 API controllers (mobile)
│   │   │   ├── Auth/              # Login/forgot/reset for admin + student
│   │   │   ├── Front/             # 7 front-CMS controllers
│   │   │   ├── Gateway/           # 9 payment gateway IPN handlers
│   │   │   ├── OnlineAdmission/   # 4 online admission controllers
│   │   │   ├── Student/           # 16 student portal controllers
│   │   │   └── {Welcome,Cron,Webhooks}Controller.php
│   │   ├── Middleware/            # 8 middlewares (auth, rbac, locale, etc.)
│   │   ├── Requests/              # Form request validators
│   │   └── ViewComposers/         # Admin/Student/Front layout composers
│   ├── Listeners/                 # Domain event listeners
│   ├── Mail/                      # Mailables (StaffPasswordReset, UserPasswordReset)
│   ├── Models/                    # 103 Eloquent models with relationships
│   ├── Notifications/             # Database notifications
│   ├── Policies/                  # Authorization policies
│   ├── Providers/                  # App, Auth, Broadcast, Event, Route service providers
│   ├── Services/                  # 11 service classes (Customlib, AuthManager, Rbac, etc.)
│   └── View/Components/           # Blade components
├── bootstrap/
│   └── app.php                    # Laravel 11+ bootstrap (middleware aliases, routing)
├── config/                        # All Laravel + custom config (auth, app, school, modules, permission)
├── database/
│   ├── migrations/                # 103 migrations for 207 source tables
│   ├── factories/                 # Model factories
│   └── seeders/
│       └── DatabaseSeeder.php     # Composite seeder (language, roles, permissions, settings, sample data)
├── lang/
│   └── en/                        # English translations (messages, pagination, validation)
├── public/
│   ├── backend/                   # AdminLTE 2.x assets (~94 MB) — copied from source
│   ├── themes/                    # 8 front-CMS themes — copied from source
│   ├── uploads/                   # Sample uploaded files
│   ├── index.php                  # Front controller
│   └── .htaccess
├── resources/
│   ├── views/
│   │   ├── admin/                 # Admin module CRUD views (24 modules × 4 views = 96 files)
│   │   ├── auth/                  # Login/forgot/reset views (admin + student)
│   │   ├── errors/                # 403, 404, 500, maintenance error pages
│   │   ├── front/                 # Front-CMS home, page, admission views
│   │   ├── layouts/               # 4 master layouts (admin, student, front, auth)
│   │   ├── student/               # Student portal dashboard
│   │   └── emails/                # Email templates (staff-reset, user-reset, fee-reminder, fee-receipt, absent)
│   ├── css/                       # Sass source
│   └── js/                        # JS entry point
├── routes/
│   ├── web.php                    # Public + auth + group prefixes
│   ├── admin.php                  # 87 admin resource routes
│   ├── student.php                # 16 student portal routes
│   ├── api.php                    # 15 API routes + datatables endpoints
│   ├── front.php                  # 7 front-CMS routes
│   ├── gateway.php                # 9 payment gateway routes
│   ├── online_admission.php       # 4 online admission routes
│   ├── console.php                # Scheduled tasks
│   └── channels.php               # Broadcast channels
├── storage/
│   ├── app/                       # Uploaded files (public disk)
│   ├── framework/                  # Cache, sessions, views
│   └── logs/                      # Laravel log files
├── tests/                         # PHPUnit tests (Feature, Unit)
├── .env.example                   # Environment template
├── composer.json                  # PHP dependencies
├── package.json                   # Node dependencies (for asset compilation)
├── vite.config.js                 # Vite build configuration
└── README.md                      # This file
```

---

## 🔄 CI3 → Laravel 12 Mapping Reference

See `MIGRATION-GUIDE.md` for a complete file-by-file mapping between the original CodeIgniter 3 source and the Laravel 12 equivalent.

Key conceptual mappings:

| CI3 Concept | Laravel 12 Equivalent |
|-------------|----------------------|
| `application/controllers/*.php` (action methods) | `app/Http/Controllers/*.php` (resource methods) |
| `application/models/*.php` (153 files) | `app/Models/*.php` (103 models with relationships) |
| `application/views/layout/{header,sidebar,footer}.php` (triple-load) | `resources/views/layouts/admin.blade.php` (Blade `@extends`/`@yield`) |
| `application/libraries/Customlib.php` (god class, 2300 lines) | `app/Services/Customlib.php` (focused methods) + `App\Facades\Customlib` |
| `application/libraries/Auth.php` | `app/Services/AuthManager.php` + custom `AdminGuard` / `StudentGuard` |
| `application/libraries/Rbac.php` | `app/Services/RbacService.php` + `Spatie\Permission` |
| `application/libraries/Mailgateway.php` | `app/Services/MailgatewayService.php` + `Mail` facade |
| `application/libraries/Smsgateway.php` (15 providers, 3145 lines) | `app/Services/SmsgatewayService.php` (one method per provider) |
| `application/libraries/Media_storage.php` | `app/Services/MediaStorageService.php` + `Storage` facade |
| `application/helpers/*.php` (7 files, 70 functions) | `app/Helpers/*.php` (8 files, same functions) |
| `application/config/autoload.php` (libraries/helpers) | `composer.json` autoload.files + service container bindings |
| `application/config/routes.php` | `routes/web.php` + `routes/admin.php` + `routes/student.php` etc. |
| `application/config/config.php` | `.env` + `config/app.php` |
| `application/config/database.php` | `.env` + `config/database.php` |
| `application/hooks/maintenance_hook.php` | `app/Http/Middleware/MaintenanceMode.php` |
| `application/core/MY_Controller.php` (base controllers) | `app/Http/Middleware/{AuthenticateAdmin,AuthenticateStudent}.php` |
| `application/language/{lang}/system_lang.php` (77 languages) | `lang/{locale}/*.php` (Laravel localization) |
| `system/core/Loader.php` (`$this->load->view()`) | `view()->render()` / Blade `@include` |
| `system/database/DB_query_builder.php` | `Illuminate\Database\Query\Builder` (Eloquent) |
| `application/third_party/mpdf/` | `mpdf/mpdf` composer package |
| `application/third_party/google/` | `google/apiclient` composer package |
| `application/third_party/omnipay/` | `league/omnipay` + `omnipay/stripe` + `omnipay/paypal` |

---

## 🔐 Two-Guard Authentication

The original CI3 project used two separate session blobs (`$this->session->userdata('admin')` and `$this->session->userdata('student')`). This Laravel 12 port replicates that with two custom guards defined in `config/auth.php`:

```php
'admin' => [
    'driver' => 'admin',
    'provider' => 'staff',  // App\Models\Staff
],
'student' => [
    'driver' => 'student',
    'provider' => 'users',  // App\Models\User
],
```

Usage:
```php
auth('admin')->user();    // Staff instance
auth('student')->user();  // User instance

// In routes:
Route::middleware('auth.admin')->group(...);
Route::middleware('auth.student')->group(...);
```

---

## 🛡 RBAC Permission System

The original CI3 used a four-action RBAC convention (`can_view`, `can_add`, `can_edit`, `can_delete`) stored in the `roles_permissions` table. This Laravel 12 port wraps Spatie's `laravel-permission` package to maintain backward compatibility while exposing the standard Spatie API:

```php
// Check permission (anywhere)
app(RbacService::class)->hasPermission('student.view');

// In Blade:
@can('student.view') ... @endcan
@can('student.create') <a href="...">Add</a> @endcan

// In routes (middleware):
Route::get('/student', ...)->middleware('rbac:student.view');

// Original CI3 method still supported:
app(RbacService::class)->hasPrivilege('student', 'add');  // → student.create

// Super Admin (role id 7 in CI3) bypasses all permission checks automatically
// via Gate::before() in AuthServiceProvider.
```

---

## 🌍 Multi-Language Support

The original CI3 project shipped with **77 language directories** under `application/language/`. This Laravel 12 port uses Laravel's native localization:

```
lang/
├── en/    # English (default)
├── ar/    # Arabic (RTL)
├── hi/    # Hindi
├── bn/    # Bengali
├── es/    # Spanish
├── fr/    # French
├── de/    # German
├── ur/    # Urdu (RTL)
└── zh/    # Chinese
```

Locale is set automatically per-request by `SetAppLocale` middleware based on the user's `language_id`. To add more languages, create a new folder under `lang/` and add the locale code to the database `language` table.

---

## 📅 Scheduled Tasks

The original CI3 project exposed cron tasks as HTTP endpoints (e.g. `/cron/feereminder/{key}`). This Laravel 12 port uses Laravel's native scheduler in `routes/console.php`:

```bash
# Run all scheduled tasks
php artisan schedule:run

# Or set up a system cron entry:
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

| Schedule | Task |
|----------|------|
| Daily at 09:00 | `fees:reminder` — Send fee reminders via SMS + Email + Push |
| Daily at 08:00 | `birthday:sms` — Wish happy birthday to students |
| Weekdays at 11:00 | `absent:sms` — Notify parents of absent students |
| 1st of each month at 09:00 | `salary:reminder` — Staff salary reminder |
| Daily at 02:00 | `examreport:generate` — Auto-generate exam reports |
| Daily at 00:30 | `inactive:students` — Mark inactive students |
| Every 5 min | `attendance:sync` — Biometric attendance sync |

---

## 🧪 Running Tests

```bash
php artisan test
# or
./vendor/bin/phpunit
```

---

## 📦 Building Production Assets

```bash
npm install
npm run build         # Production build via Vite
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize
```

---

## 🆘 Troubleshooting

### Common Issues

**1. "No application encryption key has been specified."**
```bash
php artisan key:generate
```

**2. "The stream or file could not be opened" (storage permissions)**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**3. "SQLSTATE[HY000] [2002] Connection refused"**
- Verify MySQL is running: `sudo systemctl status mysql`
- Verify `.env` DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

**4. "Class App\Services\Customlib not found"**
```bash
composer dump-autoload
```

**5. Login form returns "These credentials do not match our records."**
- Make sure you ran `php artisan db:seed --class=AdminUserSeeder` (or `php artisan smart-academy:install`)
- Default credentials: `admin` / `admin123`

**6. Student login fails on legacy CI3 password**
- Run `php artisan smart-academy:hash-user-passwords` to upgrade all plain-text passwords to bcrypt.

---

## 📜 License

MIT License. Original CI3 project copyright remains with [SirajCse](https://github.com/SirajCse).

---

## 🙏 Acknowledgements

- Original project: [smart-academy](https://github.com/SirajCse/smart-academy) by SirajCse
- CodeIgniter 3 → Laravel 12 migration patterns: Laravel docs
- AdminLTE theme: [ColorlibHQ/AdminLTE](https://github.com/ColorlibHQ/AdminLTE)
