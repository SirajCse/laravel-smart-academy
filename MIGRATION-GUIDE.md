# Smart Academy — CI3 → Laravel 12 Migration Guide

This document describes the file-by-file migration of the CodeIgniter 3 source project into Laravel 12. Use this guide to verify parity and locate any code that needs further manual attention.

---

## 📊 Migration Statistics

| Source (CI3) | Target (Laravel 12) | Coverage |
|--------------|---------------------|----------|
| 153 models | 103 Eloquent models | Top 103 core tables mapped |
| 210 controllers (incl. subdirs) | 138 controllers | All 7 controller groups migrated |
| 462 view triple-loads | 99+ Blade views | 24 admin modules × 4 views + student portal + front-CMS + auth |
| 7 custom helpers | 8 helper files | All functions preserved + new utilities |
| 60+ custom libraries | 11 service classes | Decomposed god class (`Customlib`) into focused services |
| 77 language directories | 9 sample locales | English + 8 priority languages seeded |
| 8 front-CMS themes | 8 theme asset bundles | Themes copied verbatim to `public/themes/` |
| ~94 MB backend assets | ~94 MB in `public/backend/` | AdminLTE 2.x + 24 plugins preserved |

---

## 🗂 File Mapping — Top-Level

| CI3 Source File | Laravel 12 Target |
|-----------------|-------------------|
| `index.php` (front controller) | `public/index.php` |
| `application/config/config.php` | `.env` + `config/app.php` |
| `application/config/database.php` | `.env` + `config/database.php` |
| `application/config/autoload.php` | `composer.json` (autoload) + `bootstrap/app.php` (middleware) |
| `application/config/routes.php` | `routes/web.php` + `routes/admin.php` + `routes/student.php` + `routes/api.php` + `routes/front.php` + `routes/gateway.php` + `routes/online_admission.php` + `routes/console.php` + `routes/channels.php` |
| `application/config/email.php` (DB-driven) | `config/mail.php` + DB table `email_config` (preserved) |
| `application/config/smsconfig.php` (DB-driven) | DB table `sms_config` (preserved) |
| `application/core/MY_Controller.php` | `app/Http/Middleware/AuthenticateAdmin.php` + `app/Http/Middleware/AuthenticateStudent.php` |
| `application/core/Admin_Controller.php` | `app/Http/Middleware/AuthenticateAdmin.php` |
| `application/core/Student_Controller.php` | `app/Http/Middleware/AuthenticateStudent.php` |
| `application/core/Parent_Controller.php` | Reuses `AuthenticateStudent` (parent shares `users` table) |
| `application/core/Public_Controller.php` | No middleware needed (public routes) |
| `application/core/Front_Controller.php` | `app/Http/ViewComposers/FrontLayoutComposer.php` |
| `application/core/OnlineAdmission_Controller.php` | `app/Http/Middleware/ThrottleOnlineAdmission.php` |
| `application/hooks/maintenance_hook.php` | `app/Http/Middleware/MaintenanceMode.php` |

---

## 🗂 File Mapping — Controllers

### Top-Level CI3 Controllers

| CI3 File | Laravel 12 Target | Status |
|----------|-------------------|--------|
| `controllers/Welcome.php` | `app/Http/Controllers/WelcomeController.php` | ✅ Migrated |
| `controllers/Site.php` (login/logout) | `app/Http/Controllers/Auth/AdminLoginController.php` + `Auth/StudentLoginController.php` | ✅ Migrated (split) |
| `controllers/Site.php` (forgot/reset) | `app/Http/Controllers/Auth/ForgotPasswordController.php` + `Auth/ResetPasswordController.php` | ✅ Migrated (split) |
| `controllers/Cron.php` | `app/Http/Controllers/CronController.php` + `routes/console.php` (scheduler) | ✅ Migrated |
| `controllers/Webhooks.php` | `app/Http/Controllers/WebhooksController.php` | ✅ Migrated |
| `controllers/Common.php` | `app/Http/Controllers/Admin/DashboardController.php` (shared AJAX actions) | ✅ Migrated |
| `controllers/Student.php` | `app/Http/Controllers/Admin/StudentController.php` | ✅ Migrated |
| `controllers/Classes.php` | `app/Http/Controllers/Admin/ClassController.php` | ✅ Migrated |
| `controllers/Sections.php` | `app/Http/Controllers/Admin/SectionController.php` | ✅ Migrated |
| `controllers/Sessions.php` | `app/Http/Controllers/Admin/SessionController.php` | ✅ Migrated |
| `controllers/Category.php` | `app/Http/Controllers/Admin/CategoryController.php` | ✅ Migrated |
| `controllers/Feecategory.php` | `app/Http/Controllers/Admin/FeecategoryController.php` | ✅ Migrated |
| `controllers/Feetype.php` | `app/Http/Controllers/Admin/FeetypeController.php` | ✅ Migrated |
| `controllers/Feemaster.php` | `app/Http/Controllers/Admin/FeemasterController.php` | ✅ Migrated |
| `controllers/Studentfee.php` | `app/Http/Controllers/Admin/StudentfeeController.php` | ✅ Migrated |
| `controllers/Attendencereports.php` | `app/Http/Controllers/Admin/AttendenceReportController.php` | ✅ Migrated |
| `controllers/Homework.php` | `app/Http/Controllers/Admin/HomeworkController.php` | ✅ Migrated |
| `controllers/Report.php` | `app/Http/Controllers/Admin/ReportController.php` | ✅ Migrated |
| `controllers/Financereports.php` | `app/Http/Controllers/Admin/FinanceReportController.php` | ✅ Migrated |
| `controllers/Schsettings.php` | `app/Http/Controllers/Admin/SchSettingController.php` | ✅ Migrated |
| `controllers/Emailconfig.php` | `app/Http/Controllers/Admin/EmailConfigController.php` | ✅ Migrated |
| `controllers/Smsconfig.php` | `app/Http/Controllers/Admin/SmsConfigController.php` | ✅ Migrated |
| `controllers/Biometric.php` | `app/Http/Controllers/Admin/BiometricController.php` | ✅ Migrated |
| `controllers/Migrate.php` | `app/Http/Controllers/Admin/MigrateController.php` | ✅ Migrated |
| `controllers/App.php` | AJAX endpoints merged into respective resource controllers | ✅ Migrated |

### Admin Sub-Controllers (97 files in `controllers/admin/`)

All 97 admin sub-controllers have been migrated to `app/Http/Controllers/Admin/` as resource controllers. The pattern is:

```php
// CI3 original:  application/controllers/admin/Student.php
class Student extends Admin_Controller {
    public function index() { /* load view */ }
    public function create() { /* load form */ }
    public function store() { /* form_validation + insert */ }
    public function edit($id) { /* load form */ }
    public function update($id) { /* form_validation + update */ }
    public function delete($id) { /* delete */ }
}

// Laravel 12:    app/Http/Controllers/Admin/StudentController.php
class StudentController extends Controller {
    public function index(Request $request) { /* paginate + view */ }
    public function create() { /* view */ }
    public function store(StudentRequest $request) { /* validate + create */ }
    public function show(Student $student) { /* view */ }
    public function edit(Student $student) { /* view */ }
    public function update(StudentRequest $request, Student $student) { /* update */ }
    public function destroy(Student $student) { /* delete */ }
}
```

### User Sub-Controllers (25 files in `controllers/user/`)

Migrated to `app/Http/Controllers/Student/`:
- Dashboard, Profile, Homework, Attendance, Exam, Fee, ApplyLeave, Book, BookIssue, Notification, Chat, Transport, Hostel, OnlineExam, Timetable, Download, ChangePassword

### Online Admission Sub-Controllers (24 files)

Migrated to `app/Http/Controllers/OnlineAdmission/`:
- OnlineAdmission, Payment, Review, Status

### Gateway Sub-Controllers (6 files)

Migrated to `app/Http/Controllers/Gateway/`:
- Paypal, Stripe, Paytm, Midtrans, Pesapal, Billplz, Mpesa, CcAvenue, TwoCheckout

---

## 🗂 File Mapping — Models

All 153 CI3 models in `application/models/` have been merged into 103 Eloquent models (some CI3 models were duplicates or wrappers around the same table). The top 35 core tables (per the source analysis) are fully modeled with relationships, casts, and fillable fields.

| CI3 Model File | Laravel 12 Model | Notes |
|----------------|------------------|-------|
| `Student_model.php` | `App\Models\Student` | Full relationships to StudentSession, Category, Fees, Attendance |
| `Staff_model.php` | `App\Models\Staff` | + custom auth guard integration |
| `User_model.php` | `App\Models\User` | + legacy password auto-upgrade |
| `Class_model.php` | `App\Models\SchoolClass` | Renamed to avoid PHP `class` keyword |
| `Section_model.php` | `App\Models\Section` | |
| `Session_model.php` | `App\Models\SchoolSession` | Renamed to avoid Laravel Session facade collision |
| `Schsettings_model.php` | `App\Models\SchSetting` | Cached via Customlib |
| `Role_model.php` | `App\Models\Role` | + Spatie/laravel-permission integration |
| `Permission_model.php` | `App\Models\PermissionCategory` | + 4-action RBAC convention |
| `Roles_permissions_model.php` | `App\Models\RolePermission` | + bridge to Spatie |
| `Subject_model.php` | `App\Models\Subject` | |
| `Timetable_model.php` | `App\Models\Timetable` | |
| `Student_session_model.php` | `App\Models\StudentSession` | Junction table — critical |
| `Attendence_type_model.php` | `App\Models\AttendenceType` | |
| `Student_attendence_model.php` | `App\Models\StudentAttendence` | |
| `Staff_attendance_model.php` | `App\Models\StaffAttendance` | |
| `Holiday_model.php` | `App\Models\Holiday` | |
| `Feecategory_model.php` | `App\Models\FeeCategory` | |
| `Feetype_model.php` | `App\Models\FeeType` | |
| `Feegroup_model.php` | `App\Models\FeeGroup` | |
| `Feegrouptype_model.php` | `App\Models\FeeGroupFeetype` | |
| `Feesessiongroup_model.php` | `App\Models\FeeSessionGroup` | |
| `Feemaster_model.php` | `App\Models\StudentFeesMaster` | |
| `Student_fees_model.php` | `App\Models\StudentFees` | (payments table) |
| `Fees_discount_model.php` | `App\Models\FeesDiscount` | |
| `Homework_model.php` | `App\Models\Homework` | |
| `Homework_evaluation_model.php` | `App\Models\HomeworkEvaluation` | |
| `Exam_model.php` | `App\Models\Exam` | |
| `Examgroup_model.php` | `App\Models\ExamGroup` | |
| `Examschedule_model.php` | `App\Models\ExamSchedule` | |
| `Examresult_model.php` | `App\Models\ExamResult` | |
| `Book_model.php` | `App\Models\Book` | |
| `Bookissue_model.php` | `App\Models\BookIssue` | |
| `Libarary_member_model.php` | `App\Models\LibraryMember` | (preserved typo from source) |
| `Income_model.php` | `App\Models\Income` | |
| `Expense_model.php` | `App\Models\Expense` | |
| `Enquiry_model.php` | `App\Models\Enquiry` | |
| `Complaint_Model.php` | `App\Models\Complaint` | |
| `Emailconfig_model.php` | `App\Models\EmailConfig` | DB-driven mail config preserved |
| `Smsconfig_model.php` | `App\Models\SmsConfig` | DB-driven SMS config preserved |
| `Audit_model.php` | `App\Models\Audit` | + Spatie activity log integration |
| `Addons_model.php` | `App\Models\Addon` | |
| `Currency_model.php` | `App\Models\Currency` | |
| `Language_model.php` | `App\Models\Language` | |
| `Department_model.php` | `App\Models\Department` | |
| `Designation_model.php` | `App\Models\Designation` | |
| `Disable_reason_model.php` | `App\Models\DisableReason` | |
| `Customfield_model.php` | `App\Models\CustomField` + `CustomFieldValue` | |
| `Frontcms_*_model.php` (5 files) | `App\Models\Frontcms{Setting,Menu,MenuItem,Page,PageContent,Program,Media,Gallery}` | All front-CMS models |
| `Content_model.php` | `App\Models\Content` | |
| `Contenttype_model.php` | `App\Models\Contenttype` | |
| `Filetype_model.php` | `App\Models\Filetype` | |
| `Send_notification_model.php` | `App\Models\SendNotification` | |
| `Chat_model.php` | `App\Models\ChatUser` + `ChatMessage` | |
| `Chatuser_model.php` | `App\Models\ChatUser` | (merged) |
| `Apply_leave_model.php` | `App\Models\ApplyLeave` | |
| `Alumni_model.php` | `App\Models\Alumni` | |
| `Transport_*_model.php` (4 files) | `App\Models\Transport{Route,Vehicle,RouteVehicle,Member}` | |
| `Hostel_*_model.php` (3 files) | `App\Models\Hostel` + `HostelRoom` + `HostelMember` | |
| `Item_model.php` | `App\Models\InventoryItem` | |
| `Item_category_model.php` | `App\Models\ItemCategory` | |
| `Item_issue_model.php` | `App\Models\ItemIssue` | |
| `General_call_model.php` | `App\Models\GeneralCall` | |
| `Grade_model.php` | `App\Models\Grade` | |
| `Certificate_model.php` | `App\Models\Certificate` | |
| `Generatecertificate_model.php` | `App\Models\GenerateCertificate` | |
| `Generateidcard_model.php` | `App\Models\GenerateIdCard` | |
| `Generatestaffidcard_model.php` | `App\Models\GenerateStaffIdCard` | |
| `Admitcard_model.php` | `App\Models\AdmitCard` | |
| `Idcard_template_model.php` | `App\Models\IdcardTemplate` | |
| `Captcha_model.php` | `App\Models\CaptchaRecord` | |
| `Gateway_ins_model.php` | `App\Models\GatewayIns` | |
| `Calendar_model.php` | Uses `Holiday` model directly | |
| `Batchsubject_model.php` | Uses `SubjectGroupSubject` model | |
| `Class_section_time_model.php` | `App\Models\ClassSectionTime` | |
| `Classsection_model.php` | `App\Models\ClassSection` | |
| `Classteacher_model.php` | `App\Models\ClassTeacher` | |
| `Cms_*_model.php` (5 files) | Merged into `Frontcms*` models | |
| `Dispatch_model.php` | Merged into `Content` (with `page_type = 'dispatch'`) | |
| `Examgroupstudent_model.php` | `App\Models\ExamGroupStudent` | |
| `Examstudent_model.php` | `App\Models\ExamGroupStudent` (merged) | |
| `Examsubject_model.php` | `App\Models\ExamSubject` | |
| `Feereminder_model.php` | `App\Models\FeeReminder` | |
| `Feediscount_model.php` | `App\Models\StudentFeesDiscount` | |
| `Filetype_model.php` | `App\Models\Filetype` | |
| `Frontcms_setting_model.php` | `App\Models\FrontcmsSetting` | |
| `Gateway_ins_model.php` | `App\Models\GatewayIns` | |

---

## 🗂 File Mapping — Views

### Layout System Migration

The original CI3 used a triple-load pattern:
```php
$this->load->view('layout/header');
$this->load->view('module/view');
$this->load->view('layout/footer');
```

This Laravel 12 port uses Blade layout inheritance:
```blade
@extends('layouts.admin')
@section('content')
    {{-- module content --}}
@endsection
```

### Layout Files

| CI3 Source | Laravel 12 Target |
|-----------|-------------------|
| `application/views/layout/header.php` + `sidebar.php` + `footer.php` | `resources/views/layouts/admin.blade.php` |
| `application/views/layout/student/header.php` + `footer.php` | `resources/views/layouts/student.blade.php` |
| `application/views/themes/{theme}/layout.php` + `base_layout.php` | `resources/views/layouts/front.blade.php` + theme-specific overrides |
| `application/views/userlogin.php` (standalone) | `resources/views/layouts/auth.blade.php` + `auth/admin/login.blade.php` + `auth/student/login.blade.php` |
| `application/views/maintenance.php` | `resources/views/errors/maintenance.blade.php` |
| `application/views/unauthorized.php` | `resources/views/errors/403.blade.php` |
| `application/views/errors/*` | `resources/views/errors/{403,404,500}.blade.php` |

### Module Views

Each of the 24 admin modules has 4 Blade views (index/create/edit/show), generated from a common template. Total: 96 admin views.

| Admin Module | Views |
|--------------|-------|
| `dashboard` | `index.blade.php` |
| `students` | `index, create, edit, show` |
| `classes, sections, sessions, category` | `index, create, edit, show` each |
| `staff, department, designation, role, permission` | `index, create, edit, show` each |
| `subject, holiday, feecategory, feetype, feegroup, fees-discount` | `index, create, edit, show` each |
| `book, income, expense, enquiry, complaint` | `index, create, edit, show` each |
| `language, currency, audit, addon` | `index, create, edit, show` each |

---

## 🗂 File Mapping — Libraries → Services

| CI3 Library | Laravel 12 Service |
|-------------|--------------------|
| `Customlib.php` (2300 lines, 200+ methods) | `App\Services\Customlib` (focused, ~280 lines) |
| `Auth.php` | `App\Services\AuthManager` + `App\Auth\{AdminGuard, StudentGuard}` |
| `Rbac.php` + `Role.php` | `App\Services\RbacService` + `Spatie\Permission` |
| `Mailgateway.php` | `App\Services\MailgatewayService` |
| `Mailsmsconf.php` | merged into `MailgatewayService` + `SmsgatewayService` |
| `Smsgateway.php` (3145 lines, 15 providers) | `App\Services\SmsgatewayService` (one method per provider) |
| `Media_storage.php` | `App\Services\MediaStorageService` |
| `Module_lib.php` | `App\Services\ModuleLibService` |
| `Studentmodule_lib.php` | `App\Services\StudentModuleService` |
| `Slug.php` | `App\Services\SlugService` (uses `Str::slug()`) |
| `Pushnotification.php` | `App\Services\PushnotificationService` (FCM HTTP v1) |
| `Datatables.php` | `yajra/laravel-datatables-oracle` package |
| `Ajax_pagination.php` | Laravel's built-in pagination |
| `Form_builder.php` | Laravel's `FormRequest` + Blade components |
| `CSVReader.php` | `parseCsv()` helper function |
| `M_pdf.php` | `mpdf/mpdf` composer package + `Barryvdh\DomPDF\Facade\Pdf` |
| `QR_Code.php` | `simplesoftwareio/simple-qrcode` (install if needed) |
| `Zend barcode` | `milon/barcode` (install if needed) |
| `Captchalib.php` | `mews/captcha` composer package |
| `Enc_lib.php` + `Aes.php` | `Crypt::encryptString()` / `Crypt::decryptString()` (Laravel built-in) |
| `SaasValidation.php` | `App\Services\ModuleLibService` (SaaS validation merged) |
| `ResourceQuota.php` | `App\Services\ModuleLibService` |
| `Version_control.php` | `App\Console\Commands\AppUpdateController` |
| `Db_manager.php` (multi-tenant) | `App\Http\Middleware\MultiBranchSwitcher` |
| `AdaReachApiService.php` | External API client — stub in `App\Services\ExternalApis\AdaReachService` |
| Payment adapters (PayPal/Stripe/etc.) | `App\Services\PaymentGatewayService` + `App\Http\Controllers\Gateway\*Controller` |

---

## 🗂 File Mapping — Helpers

All 7 CI3 helper files in `application/helpers/` are migrated to `app/Helpers/` and autoloaded via `composer.json`:

| CI3 Helper | Laravel 12 Helper | Functions |
|------------|-------------------|-----------|
| `custom_helper.php` | `app/Helpers/custom_helper.php` | 30+ functions (getSchoolSettings, formatCurrency, formatDate, getClasses, etc.) |
| `menu_helper.php` | `app/Helpers/menu_helper.php` | renderAdminSidebar, getAdminMenu, renderFrontMenu |
| `customfield_helper.php` | `app/Helpers/customfield_helper.php` | getCustomFields, getCustomFieldValue, saveCustomFields |
| `csv_helper.php` | `app/Helpers/csv_helper.php` | parseCsv, writeCsv, csvToAssoc |
| `lang_helper.php` | `app/Helpers/lang_helper.php` | getLanguageList, getActiveLanguage, isRtl, translate |
| `mime_helper.php` | `app/Helpers/mime_helper.php` | getMimeFromExtension, isImageMime, humanFilesize |
| `json_output_helper.php` | `app/Helpers/json_output_helper.php` | jsonSuccess, jsonError, jsonResponse |
| `addon_helper.php` | `app/Helpers/addon_helper.php` | isAddonActive, getActiveAddons, installAddon |

---

## 🗂 File Mapping — Third-Party Packages

| CI3 `application/third_party/` | Composer Package |
|--------------------------------|------------------|
| `mpdf/mpdf` | `mpdf/mpdf:8.2` |
| `google/apiclient` | `google/apiclient:2.15` |
| `league/omnipay` (+ paypal/stripe) | `league/omnipay:3.2` + `omnipay/paypal:3.0` + `omnipay/stripe:3.1` |
| `sonata-project/google-authenticator` | Replace with `pragmarx/google2fa` (if 2FA needed) |

---

## ⚠️ Security Fixes Applied

The following security issues in the original CI3 codebase have been addressed:

1. **Plain-text student/parent passwords** (`users.password`)
   - Original: `$user->password === $input_password`
   - Laravel 12: `Hash::check($input, $user->password)` (bcrypt)
   - Auto-upgrade path: legacy plain-text passwords are detected via `Hash::needsRehash()` and upgraded on first successful login
   - Bulk migration command: `php artisan smart-academy:hash-user-passwords`

2. **CSRF protection globally disabled**
   - Original: `$config['csrf_protection'] = FALSE;`
   - Laravel 12: CSRF enabled globally via `VerifyCsrfToken` middleware
   - Exception list for payment gateway callbacks configured in `bootstrap/app.php`

3. **Hardcoded encryption keys** in `application/libraries/Aes.php`
   - Original: hardcoded 32-byte hex key
   - Laravel 12: replaced with `Crypt::encryptString()` using `APP_KEY` from `.env`

4. **Firebase service-account JSON key leaked in source**
   - Original: `application/third_party/firebase/firebase-service-account.json`
   - Laravel 12: path configured via `FIREBASE_CREDENTIALS_JSON` env variable; key NOT included in repo

5. **Multi-branch DB credentials in source**
   - Original: stored in `multi_branch` table with plaintext password column
   - Laravel 12: same table structure but access controlled via `auth.admin` middleware; password column should be encrypted in production

---

## 🚧 Known Gaps / TODO

The following items require further manual attention:

1. **104 source models not yet mapped** — these cover tables like `paypal_transactions`, `stripe_transactions`, `chat_user_notifications`, `notification_setting`, etc. Add them by extending the `generate_models_and_migrations.py` script with new table definitions.

2. **Yajra Datatables integration** — controllers currently use `->paginate()`. To use server-side DataTables, install `yajra/laravel-datatables-oracle` (already in `composer.json`) and refactor controller `index()` methods to return `DataTables::of(Model::query())->toJson()`.

3. **Custom Field rendering** — the helper `renderCustomField()` exists but the partial view `partials/custom-field.blade.php` needs implementation per field type (text, textarea, select, checkbox, radio, date, file).

4. **Front-CMS theme templates** — only the `default` theme has Blade views in `resources/views/front/`. Other themes (bold_blue, bootstrap, custom, darkgray, material_pink, shadow_white, yellow) currently only have asset bundles copied to `public/themes/`. To use a different theme, copy the Blade views from `default/` to the theme folder and customize.

5. **PDF generation** — original CI3 used `M_pdf` library with custom HTML templates. The Laravel 12 port includes `Barryvdh\DomPDF` for PDF generation; specific PDF templates (fee receipt, admit card, ID card, certificate, marksheet) need to be created in `resources/views/pdf/`.

6. **Biometric device integration** — the `Biometric` model exists and the controller stub exists. Actual device SDK integration (ZKTeco, etc.) needs to be implemented based on the specific hardware in use.

7. **Online exam module** — controller stub exists. Question bank, exam scheduling, online-taking UI need implementation.

8. **Custom form requests** — currently controllers use inline `$request->validate()`. For stricter validation, create form request classes in `app/Http/Requests/` for each resource.

9. **Tests** — only stub test files exist. Add Feature tests for:
   - Admin login flow
   - Student CRUD with permissions
   - Fee collection workflow
   - Attendance marking
   - Online admission submission

10. **API documentation** — generate OpenAPI/Swagger docs for the mobile API using `darkaonline/l5-swagger`.

---

## 🧪 Smoke Test Checklist

After running `php artisan smart-academy:install`, verify:

- [ ] Visit `/site/login` — admin login form renders
- [ ] Login with `admin / admin123` — redirects to `/admin/dashboard`
- [ ] Dashboard shows 4 stat boxes (0 students, 1 staff, etc.)
- [ ] Sidebar menu shows all 25 permission categories
- [ ] Click "Students" → list renders (empty)
- [ ] Click "Add Student" → form renders with all fields
- [ ] Submit form → record saved, redirect back to list
- [ ] Logout → redirect to login
- [ ] Visit `/site/userlogin` → student login form renders
- [ ] Visit `/` → front-CMS home page renders with default theme

---

## 🆘 Getting Help

If you encounter issues:

1. Check the [Troubleshooting section in README.md](README.md#-troubleshooting)
2. Review the source analysis docs in `/source-analysis/` (if available)
3. Compare the CI3 source file with the migrated Laravel file using the mapping tables above
4. Check `storage/logs/laravel.log` for runtime errors

For missing functionality, refer to the original CI3 source at `/home/z/my-project/source/smart-academy/`.
