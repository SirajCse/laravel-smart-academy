# Smart Academy — Laravel 12 (Shadcn UI Edition)

A complete school management system built on **Laravel 12** with a **professional
Shadcn-style admin UI** (Tailwind CSS + plain vanilla JS + DataTables — no Vue,
no React, no SPA complexity).

---

## ✨ Highlights

- 🎨 **Professional Shadcn UI** — Card / Button / Input / Select / Badge / Avatar / DataTable / StatCard components, all as anonymous Blade components
- 🌗 **Dark mode** — toggle in the header, persists in localStorage
- 📊 **Dashboard** — 4 stat cards + Chart.js charts (fee collection bar + attendance donut) + recent admissions table + upcoming events + quick actions
- 📋 **DataTables** — every list page uses DataTables with search, sort, pagination, CSV/Excel/Print export buttons
- 🗂️ **113 migrations** — full schema including Spatie permission tables + cache/sessions/jobs/password_reset_tokens
- 🧪 **5/5 PHPUnit tests passing** + 127/127 admin routes return HTTP 200 in smoke test
- 🌍 **9 languages** seeded by default (English, Arabic, Hindi, Bengali, Spanish, French, German, Urdu, Chinese)
- 📱 **Responsive** — sidebar collapses on mobile, tables scroll horizontally, forms stack

---

## 🚀 Quick Start

```bash
# 1. Extract the ZIP
unzip laravel-smart-academy-fixed.zip
cd laravel-smart-academy

# 2. Install PHP dependencies
composer install --no-dev --optimize-autoloader

# 3. (Optional) Build Tailwind CSS via Vite
npm install
npm run build
# Or skip this — the layout auto-falls-back to CDN Tailwind if no build/ folder exists

# 4. Configure environment
cp .env.example .env
php artisan key:generate

# Edit .env — set your DB credentials:
#   DB_CONNECTION=mysql
#   DB_HOST=127.0.0.1
#   DB_DATABASE=laravel_smart_academy
#   DB_USERNAME=root
#   DB_PASSWORD=

# 5. Migrate + seed
php artisan migrate:fresh --seed

# 6. Create storage symlink
php artisan storage:link

# 7. Start the dev server
php artisan serve
# Visit http://localhost:8000/site/login
```

## 🔑 Default Login

| Field    | Value                       |
|----------|-----------------------------|
| URL      | `/site/login`               |
| Username | `admin@smart-academy.local` |
| Password | `admin123`                  |

---

## 🎨 UI Architecture

### Tailwind CSS + Vite

The project ships with Tailwind 4 via Vite (`resources/css/app.css`).
After `npm install && npm run build`, compiled assets land in `public/build/`
and `@vite()` directives serve them with proper cache-busting.

**Fallback for first run:** If `public/build/manifest.json` doesn't exist
(you haven't run `npm build` yet), the layout auto-falls-back to the Tailwind
Play CDN + DataTables CDN — so the UI works immediately without `npm`.

### Shadcn-style Blade Components

All reusable components live in `resources/views/components/`:

| Component        | Usage                                           |
|------------------|--------------------------------------------------|
| `<x-card>`       | Card container with shadow                       |
| `<x-card-header>`| Card header section                              |
| `<x-card-title>` | Card title (h3)                                  |
| `<x-card-content>` | Card body                                     |
| `<x-button>`     | Button or link button (default/outline/ghost/destructive/success variants) |
| `<x-input>`      | Form input with focus ring                       |
| `<x-textarea>`   | Form textarea                                    |
| `<x-select>`     | Form select dropdown                             |
| `<x-label>`      | Form label                                       |
| `<x-form-field>` | Wraps label + input + description                |
| `<x-badge>`      | Status badge (default/success/warning/info/destructive) |
| `<x-avatar>`     | User avatar with image or fallback initials     |
| `<x-stat-card>`  | Dashboard stat card with icon + trend            |
| `<x-page-header>`| Page title + description + action buttons row    |
| `<x-data-table>` | DataTables-wrapped table                         |

Example usage:
```blade
<x-card>
    <x-card-header>
        <x-card-title>Student Information</x-card-title>
        <x-card-description>Fill in the details below</x-card-description>
    </x-card-header>
    <x-card-content>
        <div class="grid grid-cols-2 gap-4">
            <x-form-field label="First Name" required>
                <x-input name="firstname" required />
            </x-form-field>
            <x-form-field label="Gender">
                <x-select name="gender" :options="['male' => 'Male', 'female' => 'Female']" />
            </x-form-field>
        </div>
        <x-button type="submit">Save</x-button>
    </x-card-content>
</x-card>
```

### Plain Vanilla JS (No Vue/React)

- **Alpine.js** (3 KB) for dropdowns, modals, theme toggle
- **jQuery** + **DataTables** for tables (search, sort, paginate, export)
- **Chart.js** for dashboard charts

### Theme Toggle

Dark mode toggle in the header (moon/sun icon). State is persisted in
`localStorage.theme` and applied via a `.dark` class on `<html>`. All
Shadcn design tokens use CSS variables, so the same Tailwind build supports
both themes.

### Sidebar Navigation

The sidebar is organized into 13 functional groups with proper icons:

| Group            | Modules                                                        |
|------------------|----------------------------------------------------------------|
| Students         | Students, Categories, Classes, Sections, Sessions, Alumni      |
| Academics        | Subjects, Subject Groups, Timetable, Homework, Attendance, Holidays |
| Examinations    | Exam Groups, Exams, Exam Schedule, Exam Results, Grades, Admit Cards |
| Fees            | Collect Fees, Fee Categories, Fee Types, Fee Groups, Session Groups, Fee Master, Discounts |
| Finance         | Income, Expense                                                |
| Personnel        | Staff, Roles, Departments, Designations                        |
| Library         | Books, Book Issues                                              |
| Operations      | Inventory, Transport, Hostel                                   |
| Front Office    | Enquiries, Complaints, Visitors                                |
| Front CMS       | Pages, Media, Menus                                            |
| Communicate     | Notifications, Chat                                             |
| Reports         | Student, Fee, Balance Sheet                                    |
| System          | Settings, Audit Log, Addons, Email Config, SMS Config, Languages, Currencies |

---

## 📁 Project Statistics

| Layer              | Count  |
|--------------------|--------|
| Migrations         | 113    |
| Models             | 103    |
| Admin controllers  | 99     |
| Student controllers | 16    |
| API controllers    | 15     |
| Gateway controllers | 9     |
| Front-CMS controllers | 7   |
| Blade views        | 458    |
| Blade components   | 17     |
| Routes             | 883    |
| Service classes    | 11     |
| Middleware         | 9      |
| Helper files       | 8      |
| PHPUnit tests      | 5 (passing) |
| Seeders           | 9      |

---

## 🛠 Tech Stack

- **PHP** 8.2+
- **Laravel** 12.x
- **MySQL** 5.7+ / MariaDB 10.3+ / SQLite 3.35+ (works with all)
- **Tailwind CSS** 4.x (via Vite)
- **Alpine.js** 3.x (CDN)
- **jQuery** 3.7 + DataTables 2.x
- **Chart.js** 4.x
- **Font Awesome** 6.x (CDN)
- **Spatie Permission** 6.x
- **Yajra DataTables** 12.x
- **Barryvdh DomPDF** 3.x
- **Maatwebsite Excel** 3.x
- **Intervention Image** 3.x

---

## 🔌 Asset Pipeline

```bash
# For development (watches changes):
npm run dev

# For production build:
npm run build
```

After `npm run build`, the compiled assets are in `public/build/`. The Blade
layout auto-detects the manifest and uses `@vite()` directives. If no manifest
is found (e.g., you haven't run `npm` yet), the layout falls back to CDN
versions of Tailwind, DataTables, jQuery, Alpine, Chart.js, Font Awesome.

---

## 🧪 Running Tests

```bash
vendor/bin/phpunit
# or
php artisan test
```

Tests cover:
- Login form renders
- Admin can log in with valid credentials
- Admin cannot log in with invalid credentials
- Authenticated admin can view students list
- Sample test

---

## 🆘 Troubleshooting

### "Table cache doesn't exist" error

If you see `SQLSTATE[42S02]: Base table or view not found: 1146 Table '...cache'`,
you hit the Spatie permission cache-clearing issue. Either:

1. **(Recommended)** Change `.env`:
   ```
   CACHE_STORE=file
   SESSION_DRIVER=file
   QUEUE_CONNECTION=sync
   ```
   Then `php artisan config:clear && php artisan db:seed --force`

2. Or run `php artisan migrate` again — the 4 framework migrations
   (`cache`, `sessions`, `jobs`, `password_reset_tokens`) are now included.

### Assets not loading after fresh install

The layout auto-falls-back to CDN versions of Tailwind + DataTables if the
Vite build manifest doesn't exist. To use the compiled version:
```bash
npm install
npm run build
```

### Permission denied on storage/

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### CSS looks unstyled / fonts missing

Make sure you're accessing via `php artisan serve` (not file://) so that
the `/build/` or CDN paths resolve correctly.

---

## 📦 Files in the ZIP

The ZIP excludes `vendor/`, `node_modules/`, `.git/`, `.env`, and the SQLite
database file. Run `composer install` and `npm install` to regenerate them.

---

## 📜 License

MIT License. Original CodeIgniter 3 source: [SirajCse/smart-academy](https://github.com/SirajCse/smart-academy).
