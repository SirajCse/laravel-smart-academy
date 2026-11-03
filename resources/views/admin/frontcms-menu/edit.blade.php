@extends('layouts.admin')

@section('title', __('Edit Front CMS Menu'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.frontcms-menu.index') }}" class="hover:text-foreground">Front CMS Menu</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Front CMS Menu" description="Update the front cms menu record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Front CMS Menu Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.frontcms-menu.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Title">
                <x-input name="title" type="text" placeholder="Enter title..." />
            </x-form-field>
                <x-form-field label="Slug">
                <x-input name="slug" type="text" placeholder="Enter slug..." />
            </x-form-field>
                <x-form-field label="URL">
                <x-input name="url" type="text" placeholder="Enter url..." />
            </x-form-field>
                <x-form-field label="Order">
                <x-input name="order" type="number" step="0.01" />
            </x-form-field>
                <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded border-input text-primary focus:ring-ring" { { old('is_active') ? 'checked' : '' } } />
                <x-label for="is_active">Active</x-label>
            </div>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.frontcms-menu.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
