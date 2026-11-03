@extends('layouts.admin')

@section('title', __('Edit Session'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.session.index') }}" class="hover:text-foreground">Session</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Session" description="Update the session record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Session Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.session.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Session Year">
                <x-input name="session" type="text" placeholder="Enter session year..." />
            </x-form-field>
                <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" name="is_active" value="1" id="is_active" class="rounded border-input text-primary focus:ring-ring" { { old('is_active') ? 'checked' : '' } } />
                <x-label for="is_active">Active</x-label>
            </div>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.session.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
