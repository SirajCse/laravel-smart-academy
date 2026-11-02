<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

/**
 * Media storage service — replaces CI3's `Media_storage` library.
 *
 * Centralizes file uploads/downloads across modules (students, staff,
 * homework, fees, books, etc.) and uses Laravel's filesystem disks
 * so we can swap between local / s3 / digital-ocean transparently.
 */
class MediaStorageService
{
    public function upload(UploadedFile $file, string $directory, string $prefix = 'FILE', string $disk = 'public'): string
    {
        $filename = $prefix . '_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, $disk);
    }

    public function delete(?string $path, string $disk = 'public'): bool
    {
        if (! $path) return false;
        if (! Storage::disk($disk)->exists($path)) return false;
        return Storage::disk($disk)->delete($path);
    }

    public function url(?string $path, string $disk = 'public'): string
    {
        if (! $path) return '';
        if (Str::startsWith($path, ['http://', 'https://'])) return $path;
        return Storage::disk($disk)->url($path);
    }

    public function exists(?string $path, string $disk = 'public'): bool
    {
        if (! $path) return false;
        return Storage::disk($disk)->exists($path);
    }

    public function size(?string $path, string $disk = 'public'): int
    {
        if (! $path) return 0;
        return Storage::disk($disk)->size($path);
    }

    public function download(string $path, ?string $downloadName = null, string $disk = 'public')
    {
        return Storage::disk($disk)->download($path, $downloadName);
    }

    public function tempUpload(UploadedFile $file, string $prefix = 'TEMP'): string
    {
        return $file->storeAs('temp', $prefix . '_' . Str::random(16), 'local');
    }
}
