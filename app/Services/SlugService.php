<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Slug service — replaces CI3's `Slug` library.
 *
 * URL-friendly slug generation with optional uniqueness check.
 */
class SlugService
{
    public function slugify(string $text, ?string $model = null, ?int $ignoreId = null, string $column = 'slug'): string
    {
        $slug = Str::slug($text);

        if (! $model) {
            return $slug;
        }

        $original = $slug;
        $count = 1;

        $query = app($model)::where($column, $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $original . '-' . $count++;
            $query = app($model)::where($column, $slug);
            if ($ignoreId) $query->where('id', '!=', $ignoreId);
        }

        return $slug;
    }
}
