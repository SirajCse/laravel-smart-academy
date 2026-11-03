@extends('layouts.admin')

@section('title', __('Edit Front CMS Page'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.frontcms-page.index') }}" class="hover:text-foreground">Front CMS Page</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Front CMS Page" description="Update the front cms page record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Front CMS Page Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.frontcms-page.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Title">
                <x-input name="title" type="text" placeholder="Enter title..." />
            </x-form-field>
                <x-form-field label="Slug">
                <x-input name="slug" type="text" placeholder="Enter slug..." />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
                <x-form-field label="Meta Title">
                <x-input name="meta_title" type="text" placeholder="Enter meta title..." />
            </x-form-field>
                <x-form-field label="Meta Keywords">
                <x-input name="meta_keyword" type="text" placeholder="Enter meta keywords..." />
            </x-form-field>
                <x-form-field label="Meta Description">
                <x-textarea name="meta_description" placeholder="Enter meta description..." />
            </x-form-field>
                <x-form-field label="Page Type">
                <x-select name="page_type" :options="['standard' => 'Standard', 'gallery' => 'Gallery', 'contact' => 'Contact', 'news' => 'News', 'event' => 'Event']" placeholder="Select page type" />
            </x-form-field>
                <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded border-input text-primary focus:ring-ring" { { old('is_active') ? 'checked' : '' } } />
                <x-label for="is_active">Active</x-label>
            </div>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.frontcms-page.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
