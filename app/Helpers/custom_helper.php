<?php

/**
 * Smart Academy — custom_helper.php
 *
 * Replaces CI3 application/helpers/custom_helper.php (~30 functions).
 * Loaded via composer.json "autoload.files".
 */

use App\Models\{SchSetting, Language, Currency, SchoolSession};
use Illuminate\Support\Facades\Cache;

if (! function_exists('getSchoolSettings')) {
    function getSchoolSettings(): SchSetting
    {
        return app(\App\Services\Customlib::class)->getSchoolSettings();
    }
}

if (! function_exists('getActiveSession')) {
    function getActiveSession(): ?SchoolSession
    {
        return app(\App\Services\Customlib::class)->getActiveSession();
    }
}

if (! function_exists('getActiveSessionId')) {
    function getActiveSessionId(): ?int
    {
        return app(\App\Services\Customlib::class)->getActiveSessionId();
    }
}

if (! function_exists('getLanguageName')) {
    function getLanguageName(string $code): string
    {
        return Cache::remember("lang.name.{$code}", now()->addDay(), function () use ($code) {
            return Language::where('short_code', $code)->value('language') ?: ucfirst($code);
        });
    }
}

if (! function_exists('getCurrencySymbol')) {
    function getCurrencySymbol(): string
    {
        return getSchoolSettings()->currency_symbol ?: '$';
    }
}

if (! function_exists('formatCurrency')) {
    function formatCurrency(float $amount): string
    {
        return app(\App\Services\Customlib::class)->formatCurrency($amount);
    }
}

if (! function_exists('formatDate')) {
    function formatDate($date, ?string $format = null): string
    {
        return app(\App\Services\Customlib::class)->formatDate($date, $format);
    }
}

if (! function_exists('formatTime')) {
    function formatTime($time): string
    {
        return app(\App\Services\Customlib::class)->formatTime($time);
    }
}

if (! function_exists('getSchoolLogo')) {
    function getSchoolLogo(): string
    {
        return app(\App\Services\Customlib::class)->getSchoolLogo();
    }
}

if (! function_exists('getSidebarImage')) {
    function getSidebarImage(): string
    {
        return app(\App\Services\Customlib::class)->getSidebarImage();
    }
}

if (! function_exists('getClasses')) {
    function getClasses(): array
    {
        return app(\App\Services\Customlib::class)->getClasses();
    }
}

if (! function_exists('getSectionsByClass')) {
    function getSectionsByClass(int $classId): array
    {
        return app(\App\Services\Customlib::class)->getSectionsByClass($classId);
    }
}

if (! function_exists('generateAdmissionNo')) {
    function generateAdmissionNo(): string
    {
        return app(\App\Services\Customlib::class)->generateAdmissionNo();
    }
}

if (! function_exists('generateInvoiceNo')) {
    function generateInvoiceNo(string $prefix = 'INV'): string
    {
        return app(\App\Services\Customlib::class)->generateInvoiceNumber($prefix);
    }
}

if (! function_exists('uploadFile')) {
    function uploadFile($file, string $path, string $prefix = 'FILE'): string
    {
        return app(\App\Services\MediaStorageService::class)->upload($file, $path, $prefix);
    }
}

if (! function_exists('deleteFile')) {
    function deleteFile(?string $path): bool
    {
        return app(\App\Services\MediaStorageService::class)->delete($path);
    }
}

if (! function_exists('fileUrl')) {
    function fileUrl(?string $path): string
    {
        return app(\App\Services\MediaStorageService::class)->url($path);
    }
}

if (! function_exists('slugify')) {
    function slugify(string $text, ?string $model = null, ?int $ignoreId = null): string
    {
        return app(\App\Services\SlugService::class)->slugify($text, $model, $ignoreId);
    }
}

if (! function_exists('formatBytes')) {
    function formatBytes(int $bytes, int $precision = 2): string
    {
        return app(\App\Services\Customlib::class)->formatBytes($bytes, $precision);
    }
}

if (! function_exists('isActiveMenu')) {
    function isActiveMenu(string $routeName, string $activeClass = 'active'): string
    {
        return request()->routeIs($routeName) ? $activeClass : '';
    }
}

if (! function_exists('currentUserRole')) {
    function currentUserRole(): ?string
    {
        return app(\App\Services\Customlib::class)->getUserRole();
    }
}

if (! function_exists('isSuperAdmin')) {
    function isSuperAdmin(): bool
    {
        return app(\App\Services\RbacService::class)->isSuperAdmin();
    }
}

if (! function_exists('studentSession')) {
    function studentSession(?int $studentId = null): ?\App\Models\StudentSession
    {
        $studentId ??= auth('student')->id();
        return $studentId ? app(\App\Services\Customlib::class)->getStudentCurrentSession($studentId) : null;
    }
}

if (! function_exists('genderList')) {
    function genderList(): array
    {
        return ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
    }
}

if (! function_exists('bloodGroups')) {
    function bloodGroups(): array
    {
        return ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
    }
}

if (! function_exists('paymentModes')) {
    function paymentModes(): array
    {
        return config('school.payment_modes', ['cash', 'cheque', 'dd', 'bank_transfer', 'online']);
    }
}

if (! function_exists('appVersion')) {
    function appVersion(): string
    {
        return '12.0.0';
    }
}
