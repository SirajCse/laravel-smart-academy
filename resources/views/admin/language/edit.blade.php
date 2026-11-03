@extends('layouts.admin')

@section('title', __('Edit Language'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.language.index') }}" class="hover:text-foreground">Language</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Language" description="Update the language record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Language Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.language.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Language Name">
                <x-input name="language" type="text" placeholder="Enter language name..." />
            </x-form-field>
                <x-form-field label="Short Code">
                <x-input name="short_code" type="text" placeholder="Enter short code..." />
            </x-form-field>
                <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" name="is_rtl" value="1" id="is_rtl" class="rounded border-input text-primary focus:ring-ring" { { old('is_rtl') ? 'checked' : '' } } />
                <x-label for="is_rtl">RTL</x-label>
            </div>
                <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded border-input text-primary focus:ring-ring" { { old('is_active') ? 'checked' : '' } } />
                <x-label for="is_active">Active</x-label>
            </div>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.language.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
