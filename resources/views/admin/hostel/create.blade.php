@extends('layouts.admin')

@section('title', __('Add Hostel'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.hostel.index') }}" class="hover:text-foreground">Hostel</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Hostel" description="Create a new hostel record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Hostel Information</x-card-title>
        <x-card-description>Fill in the details below to create a new hostel record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.hostel.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Hostel Name">
                <x-input name="hostel_name" type="text" placeholder="Enter hostel name..." />
            </x-form-field>
                <x-form-field label="Hostel Type">
                <x-select name="hostel_type" :options="['boys' => 'Boys', 'girls' => 'Girls', 'mixed' => 'Mixed']" placeholder="Select hostel type" />
            </x-form-field>
                <x-form-field label="Address">
                <x-textarea name="address" placeholder="Enter address..." />
            </x-form-field>
                <x-form-field label="Contact">
                <x-input name="contact_number" type="text" placeholder="Enter contact..." />
            </x-form-field>
                <x-form-field label="Intake">
                <x-input name="intake" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Hostel</x-button>
                <x-button :href="route('admin.hostel.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
