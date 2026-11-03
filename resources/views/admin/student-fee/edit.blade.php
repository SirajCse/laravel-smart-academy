@extends('layouts.admin')

@section('title', __('Edit Student Fees'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.student-fee.index') }}" class="hover:text-foreground">Student Fees</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Student Fees" description="Update the student fees record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Student Fees Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.student-fee.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Student Session">
                <x-select name="student_session_id" :options="[]" placeholder="Select student session" />
            </x-form-field>
                <x-form-field label="Fee Session Group">
                <x-select name="fee_session_group_id" :options="[]" placeholder="Select fee session group" />
            </x-form-field>
                <x-form-field label="Amount">
                <x-input name="amount" type="number" step="0.01" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.student-fee.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
