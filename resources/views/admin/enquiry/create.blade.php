@extends('layouts.admin')

@section('title', __('Add Enquiry'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.enquiry.index') }}" class="hover:text-foreground">Enquiry</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Enquiry" description="Create a new enquiry record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Enquiry Information</x-card-title>
        <x-card-description>Fill in the details below to create a new enquiry record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.enquiry.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Name">
                <x-input name="name" type="text" placeholder="Enter name..." />
            </x-form-field>
                <x-form-field label="Email">
                <x-input name="email" type="email" placeholder="email@example.com" />
            </x-form-field>
                <x-form-field label="Phone">
                <x-input name="phone" type="text" placeholder="Enter phone..." />
            </x-form-field>
                <x-form-field label="Purpose">
                <x-input name="purpose" type="text" placeholder="Enter purpose..." />
            </x-form-field>
                <x-form-field label="Source">
                <x-select name="source" :options="[]" placeholder="Select source" />
            </x-form-field>
                <x-form-field label="Date">
                <x-input name="date" type="date" />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
                <x-form-field label="Status">
                <x-select name="status" :options="[]" placeholder="Select status" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Enquiry</x-button>
                <x-button :href="route('admin.enquiry.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
