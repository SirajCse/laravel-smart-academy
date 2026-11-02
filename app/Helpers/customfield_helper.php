<?php

/**
 * Smart Academy — customfield_helper.php
 *
 * Replaces CI3 application/helpers/customfield_helper.php.
 * Helpers for rendering and parsing custom fields.
 */

use App\Models\CustomField;
use App\Models\CustomFieldValue;

if (! function_exists('getCustomFields')) {
    function getCustomFields(string $belongTo): \Illuminate\Database\Eloquent\Collection
    {
        return Cache()->remember("customfields.{$belongTo}", now()->addHour(), function () use ($belongTo) {
            return CustomField::where('belong_to', $belongTo)
                ->where('is_active', 1)
                ->orderBy('order')
                ->get();
        });
    }
}

if (! function_exists('getCustomFieldValue')) {
    function getCustomFieldValue(int $fieldId, int $belongId): ?string
    {
        return CustomFieldValue::where('custom_field_id', $fieldId)
            ->where('belong_id', $belongId)
            ->value('value');
    }
}

if (! function_exists('renderCustomField')) {
    function renderCustomField(CustomField $field, $value = null): string
    {
        return view('partials.custom-field', ['field' => $field, 'value' => $value])->render();
    }
}

if (! function_exists('saveCustomFields')) {
    function saveCustomFields(array $data, int $belongId, string $belongTo): void
    {
        foreach ($data as $fieldId => $value) {
            CustomFieldValue::updateOrCreate(
                ['custom_field_id' => $fieldId, 'belong_id' => $belongId],
                ['value' => $value]
            );
        }
    }
}
