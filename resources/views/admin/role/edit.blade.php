@extends('layouts.admin')

@section('title', __('Edit Role'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.role.index') }}" class="hover:text-foreground">Role</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Role" description="Update the role record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Role Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.role.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Role Name">
                <x-input name="name" type="text" placeholder="Enter role name..." />
            </x-form-field>
                <x-form-field label="Guard">
                <x-select name="guard_name" :options="['admin' => 'Admin', 'student' => 'Student']" placeholder="Select guard" />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
                <div class="flex items-center gap-2 pt-6">
                <input type="checkbox" name="is_superadmin" value="1" id="is_superadmin" class="rounded border-input text-primary focus:ring-ring" { { old('is_superadmin') ? 'checked' : '' } } />
                <x-label for="is_superadmin">Super Admin</x-label>
            </div>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.role.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
