@extends('layouts.admin')

@section('title', __('Edit Holiday'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.holiday.index') }}" class="hover:text-foreground">Holiday</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Holiday" description="Update the holiday record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Holiday Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.holiday.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Title">
                <x-input name="title" type="text" placeholder="Enter title..." />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
                <x-form-field label="From Date">
                <x-input name="from_date" type="date" />
            </x-form-field>
                <x-form-field label="To Date">
                <x-input name="to_date" type="date" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.holiday.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
