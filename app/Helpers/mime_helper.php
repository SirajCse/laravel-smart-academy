<?php

/**
 * Smart Academy — mime_helper.php
 * Replaces CI3 application/helpers/mime_helper.php.
 */

if (! function_exists('getMimeFromExtension')) {
    function getMimeFromExtension(string $extension): string
    {
        $map = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt'  => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
            'svg'  => 'image/svg+xml',
            'csv'  => 'text/csv',
            'txt'  => 'text/plain',
            'zip'  => 'application/zip',
            'rar'  => 'application/x-rar-compressed',
            'mp3'  => 'audio/mpeg',
            'mp4'  => 'video/mp4',
        ];
        return $map[strtolower($extension)] ?? 'application/octet-stream';
    }
}

if (! function_exists('isImageMime')) {
    function isImageMime(string $mime): bool
    {
        return in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml']);
    }
}

if (! function_exists('humanFilesize')) {
    function humanFilesize(int $bytes, int $precision = 2): string
    {
        return app(\App\Services\Customlib::class)->formatBytes($bytes, $precision);
    }
}
