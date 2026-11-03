@extends('layouts.admin')

@section('title', __('Add Student'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.student.index') }}" class="hover:text-foreground">Student</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Student" description="Create a new student record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Student Information</x-card-title>
        <x-card-description>Fill in the details below to create a new student record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.student.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Admission No">
                <x-input name="admission_no" type="text" placeholder="Enter admission no..." />
            </x-form-field>
                <x-form-field label="First Name">
                <x-input name="firstname" type="text" placeholder="Enter first name..." />
            </x-form-field>
                <x-form-field label="Last Name">
                <x-input name="lastname" type="text" placeholder="Enter last name..." />
            </x-form-field>
                <x-form-field label="Class">
                <x-select name="class_id" :options="[]" placeholder="Select class" />
            </x-form-field>
                <x-form-field label="Section">
                <x-select name="section_id" :options="[]" placeholder="Select section" />
            </x-form-field>
                <x-form-field label="Gender">
                <x-select name="gender" :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" placeholder="Select gender" />
            </x-form-field>
                <x-form-field label="Date of Birth">
                <x-input name="dob" type="date" />
            </x-form-field>
                <x-form-field label="Mobile">
                <x-input name="mobileno" type="text" placeholder="Enter mobile..." />
            </x-form-field>
                <x-form-field label="Email">
                <x-input name="email" type="email" placeholder="email@example.com" />
            </x-form-field>
                <x-form-field label="Father Name">
                <x-input name="father_name" type="text" placeholder="Enter father name..." />
            </x-form-field>
                <x-form-field label="Mother Name">
                <x-input name="mother_name" type="text" placeholder="Enter mother name..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Student</x-button>
                <x-button :href="route('admin.student.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
