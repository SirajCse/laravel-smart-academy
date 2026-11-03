@extends('layouts.admin')

@section('title', __('Add Department'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.department.index') }}" class="hover:text-foreground">Department</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Department" description="Create a new department record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Department Information</x-card-title>
        <x-card-description>Fill in the details below to create a new department record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.department.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Department Name">
                <x-input name="department_name" type="text" placeholder="Enter department name..." />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Department</x-button>
                <x-button :href="route('admin.department.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
