<?php

/**
 * Smart Academy — lang_helper.php
 * Replaces CI3 application/helpers/lang_helper.php.
 */

use App\Models\Language;

if (! function_exists('getLanguageList')) {
    function getLanguageList(): array
    {
        return app(\App\Services\Customlib::class)->getLanguageList();
    }
}

if (! function_exists('getActiveLanguage')) {
    function getActiveLanguage(): ?Language
    {
        $langId = session('admin.lang_id') ?: session('student.lang_id');
        return $langId ? Language::find($langId) : Language::where('is_active', 1)->first();
    }
}

if (! function_exists('isRtl')) {
    function isRtl(): bool
    {
        $settings = app(\App\Services\Customlib::class)->getSchoolSettings();
        return (bool) ($settings->is_rtl ?? false);
    }
}

if (! function_exists('translate')) {
    function translate(string $key, array $replace = []): string
    {
        return __($key, $replace);
    }
}
