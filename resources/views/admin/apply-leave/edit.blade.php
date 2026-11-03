@extends('layouts.admin')

@section('title', __('Edit Apply Leave'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.apply-leave.index') }}" class="hover:text-foreground">Apply Leave</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Apply Leave" description="Update the apply leave record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Apply Leave Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.apply-leave.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="From Date">
                <x-input name="leave_from" type="date" />
            </x-form-field>
                <x-form-field label="To Date">
                <x-input name="leave_to" type="date" />
            </x-form-field>
                <x-form-field label="Reason">
                <x-textarea name="reason" placeholder="Enter reason..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.apply-leave.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
