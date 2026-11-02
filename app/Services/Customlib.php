<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\{
    SchSetting,
    Session as SchoolSession,
    Language,
    Currency,
    StudentSession,
    Student,
    ClassSection,
    SchoolClass,
    Section,
};

/**
 * Customlib — the Smart Academy "god service".
 *
 * Replaces the CI3 `Customlib` library (`application/libraries/Customlib.php`,
 * ~2 300 lines, 200+ methods). Decomposed into focused helper methods.
 *
 * Bound as a singleton in `AppServiceProvider`. Use via:
 *   - `app(Customlib::class)->method()`
 *   - `\Customlib::method()` (Blade facade)
 *
 * Original method name → migrated method name map:
 *   getSchoolSettings()              → getSchoolSettings()
 *   getSessionList()                 → getSessionList()
 *   getLanguageList()                → getLanguageList()
 *   getCurrencyList()                → getCurrencyList()
 *   getSchoolLogo()                  → getSchoolLogo()
 *   getSidebarImage()                → getSidebarImage()
 *   getCurrencyFormat()              → formatCurrency()
 *   getDateFormat()                  → formatDate()
 *   getTimeFormat()                  → formatTime()
 *   getTaxType()                     → getTaxType()
 *   getUserData()                    → getUserData()
 *   getStudentSession()              → getStudentSession()
 *   getStudentClassSections()        → getStudentClassSections()
 *   getClasses()                     → getClasses()
 *   getSectionsByClass()             → getSectionsByClass()
 *   getStaffRole()                   → getStaffRole()
 *   getStaffRoleById()               → getStaffRoleById()
 *   getRollno()                      → generateRollNumber()
 *   getAdmissionNo()                 → generateAdmissionNo()
 *   fileUpload()                     → uploadFile()
 *   fileDelete()                     → deleteFile()
 *   imageResize()                     → resizeImage()
 *   sendSMS()                        → SmsgatewayService::send()
 *   sendEmail()                      → MailgatewayService::send()
 *   sendPushNotification()           → PushnotificationService::send()
 *   generateInvoiceNo()              → generateInvoiceNumber()
 *   formatBytes()                    → formatBytes()
 *   slugify()                        → SlugService::slugify()
 */
class Customlib
{
    /** Cached school settings. */
    private ?SchSetting $settings = null;

    public function getSchoolSettings(): SchSetting
    {
        if ($this->settings) {
            return $this->settings;
        }

        return $this->settings = Cache::remember('sch_settings', now()->addHour(), function () {
            return SchSetting::first() ?? new SchSetting([
                'school_name' => config('app.name'),
                'timezone'    => config('app.timezone'),
                'currency'    => 'USD',
                'date_format' => 'd-m-Y',
                'theme'       => 'default',
            ]);
        });
    }

    public function clearSchoolSettingsCache(): void
    {
        Cache::forget('sch_settings');
        $this->settings = null;
    }

    /**
     * Get the current active session record.
     */
    public function getActiveSession(): ?SchoolSession
    {
        return Cache::remember('active_session', now()->addHour(), function () {
            return SchoolSession::where('is_active', 1)->first()
                ?? SchoolSession::orderByDesc('id')->first();
        });
    }

    /**
     * Get the active session ID (null-safe).
     */
    public function getActiveSessionId(): ?int
    {
        return $this->getActiveSession()?->id;
    }

    public function getSessionList(): array
    {
        return Cache::remember('session_list', now()->addHour(), function () {
            return SchoolSession::orderByDesc('id')->pluck('session', 'id')->all();
        });
    }

    public function getLanguageList(): array
    {
        return Cache::remember('language_list', now()->addDay(), function () {
            return Language::where('is_active', 1)->pluck('language', 'short_code')->all();
        });
    }

    public function getCurrencyList(): array
    {
        return Cache::remember('currency_list', now()->addDay(), function () {
            return Currency::where('is_active', 1)->pluck('currency', 'id')->all();
        });
    }

    public function getSchoolLogo(): string
    {
        $settings = $this->getSchoolSettings();
        if ($settings && $settings->logo && Storage::disk('public')->exists($settings->logo)) {
            return Storage::disk('public')->url($settings->logo);
        }
        return asset('backend/dist/img/logo.png');
    }

    public function getSidebarImage(): string
    {
        $settings = $this->getSchoolSettings();
        if ($settings && $settings->sidebar && Storage::disk('public')->exists($settings->sidebar)) {
            return Storage::disk('public')->url($settings->sidebar);
        }
        return asset('backend/dist/img/photo1.png');
    }

    public function formatCurrency(float $amount): string
    {
        $settings = $this->getSchoolSettings();
        $symbol    = $settings->currency_symbol ?? '$';
        $placement = $settings->currency_place ?? 'before';

        return $placement === 'before'
            ? $symbol . number_format((float) $amount, 2)
            : number_format((float) $amount, 2) . $symbol;
    }

    public function formatDate($date, string $format = null): string
    {
        if (! $date) return '';
        $format = $format ?: ($this->getSchoolSettings()->date_format ?? 'd-m-Y');
        return \Carbon\Carbon::parse($date)->format($format);
    }

    public function formatTime($time): string
    {
        if (! $time) return '';
        return \Carbon\Carbon::parse($time)->format('h:i A');
    }

    public function getStudentSession(int $studentId, int $sessionId): ?StudentSession
    {
        return StudentSession::where('student_id', $studentId)
            ->where('session_id', $sessionId)
            ->first();
    }

    public function getStudentCurrentSession(int $studentId): ?StudentSession
    {
        $sessionId = $this->getActiveSessionId();
        return $this->getStudentSession($studentId, $sessionId);
    }

    public function getClasses(): array
    {
        return Cache::remember('classes_list', now()->addHour(), function () {
            return SchoolClass::where('is_active', 1)->pluck('class', 'id')->all();
        });
    }

    public function getSectionsByClass(int $classId): array
    {
        return Cache::remember("sections.{$classId}", now()->addHour(), function () use ($classId) {
            return Section::whereHas('classSections', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            })->pluck('section', 'id')->all();
        });
    }

    public function generateRollNumber(int $classId, int $sessionId): string
    {
        $lastRoll = StudentSession::where('class_id', $classId)
            ->where('session_id', $sessionId)
            ->join('students', 'students.id', '=', 'student_session.student_id')
            ->max('students.roll_no');

        return (string) (((int) $lastRoll) + 1);
    }

    public function generateAdmissionNo(): string
    {
        $lastAdmission = Student::max('admission_no');
        return (string) (((int) $lastAdmission) + 1);
    }

    public function generateInvoiceNumber(string $prefix = 'INV'): string
    {
        return $prefix . '-' . date('Y') . '-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Upload a file to the public disk.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $path  e.g. 'student_images'
     * @param  string  $prefix  e.g. 'STU'
     * @return string  The stored relative path.
     */
    public function uploadFile($file, string $path, string $prefix = 'FILE'): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }

    public function deleteFile(?string $path): bool
    {
        if (! $path) return false;
        return Storage::disk('public')->delete($path);
    }

    /**
     * Resize an image using Intervention Image.
     *
     * @param  string  $source  Path in the public disk
     * @param  int  $width
     * @param  int  $height
     * @return string  Path to the resized image
     */
    public function resizeImage(string $source, int $width = 200, int $height = 200, bool $keepAspect = true): string
    {
        $image = \Intervention\Image\ImageManagerStatic::make(Storage::disk('public')->path($source));
        $method = $keepAspect ? 'resize' : 'fit';
        $image->{$method}($width, $height, function ($constraint) use ($keepAspect) {
            if ($keepAspect) $constraint->aspectRatio();
            $constraint->upsize();
        });

        $resizedPath = 'resized/' . $source;
        Storage::disk('public')->put($resizedPath, (string) $image->encode());
        return $resizedPath;
    }

    public function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);
        $bytes /= (1024 ** $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Get the logged-in user's role name.
     *
     * Returns the staff role (e.g. "Super Admin", "Teacher") for admin
     * guard, or "Student"/"Parent" for student guard.
     */
    public function getUserRole(): ?string
    {
        if (auth('admin')->check()) {
            $staff = auth('admin')->user();
            return $staff?->roles?->first()?->name;
        }
        if (auth('student')->check()) {
            $user = auth('student')->user();
            return $user?->role;
        }
        return null;
    }

    /**
     * Compute the academic year for a given date based on the school's
     * configured start month.
     */
    public function getAcademicYearFromDate(\DateTimeInterface $date): string
    {
        $startMonth = (int) ($this->getSchoolSettings()->start_month ?? 4);
        $year       = (int) $date->format('Y');
        $month      = (int) $date->format('n');
        if ($month < $startMonth) $year--;
        return $year . '-' . ($year + 1);
    }
}
