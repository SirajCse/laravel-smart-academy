<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Locale middleware — mirrors CI3's `$this->customlib->getLanguage()`
 * which loads the active language from session, then sch_settings.
 *
 * Resolution order:
 *   1. Authenticated staff's `language_id` from session storage
 *   2. Authenticated student's `language_id`
 *   3. Session `admin.lang_id` (legacy CI3 key)
 *   4. `sch_settings.lang_id` (loaded via app cache)
 *   5. Fallback to `app.fallback_locale`
 */
class SetAppLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $langCode = null;

        // 1. Authenticated admin (staff)
        if (Auth::guard('admin')->check()) {
            $staff = Auth::guard('admin')->user();
            if ($staff && $staff->language_id) {
                $langCode = $this->codeFromId($staff->language_id);
            }
        }

        // 2. Authenticated student
        if (! $langCode && Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();
            if ($user && $user->language_id) {
                $langCode = $this->codeFromId($user->language_id);
            }
        }

        // 3. Legacy CI3 session key
        if (! $langCode) {
            $adminSession = Session::get('admin', []);
            $langId = $adminSession['lang_id'] ?? null;
            if ($langId) {
                $langCode = $this->codeFromId($langId);
            }
        }

        // 4. App default
        if (! $langCode) {
            $langCode = config('app.locale', 'en');
        }

        App::setLocale($langCode);

        return $next($request);
    }

    private function codeFromId(int $languageId): ?string
    {
        return cache()->remember("lang.code.{$languageId}", 86400, function () use ($languageId) {
            $lang = \App\Models\Language::find($languageId);
            return $lang?->short_code ?: null;
        });
    }
}
