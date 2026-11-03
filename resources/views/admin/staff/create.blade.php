@extends('layouts.admin')

@section('title', __('Add Staff'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.staff.index') }}" class="hover:text-foreground">Staff</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Staff" description="Create a new staff record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Staff Information</x-card-title>
        <x-card-description>Fill in the details below to create a new staff record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Staff ID">
                <x-input name="staff_id" type="text" placeholder="Enter staff id..." />
            </x-form-field>
                <x-form-field label="Name">
                <x-input name="name" type="text" placeholder="Enter name..." />
            </x-form-field>
                <x-form-field label="Email">
                <x-input name="email" type="email" placeholder="email@example.com" />
            </x-form-field>
                <x-form-field label="Phone">
                <x-input name="phone" type="text" placeholder="Enter phone..." />
            </x-form-field>
                <x-form-field label="Gender">
                <x-select name="gender" :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" placeholder="Select gender" />
            </x-form-field>
                <x-form-field label="Date of Birth">
                <x-input name="dob" type="date" />
            </x-form-field>
                <x-form-field label="Joining Date">
                <x-input name="joining_date" type="date" />
            </x-form-field>
                <x-form-field label="Password">
                <x-input name="password" type="password" placeholder="••••••••" />
            </x-form-field>
                <x-form-field label="Role">
                <x-select name="role_id" :options="[]" placeholder="Select role" />
            </x-form-field>
                <x-form-field label="Department">
                <x-select name="department_id" :options="[]" placeholder="Select department" />
            </x-form-field>
                <x-form-field label="Designation">
                <x-select name="designation_id" :options="[]" placeholder="Select designation" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Staff</x-button>
                <x-button :href="route('admin.staff.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
