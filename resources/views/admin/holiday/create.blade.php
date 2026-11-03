@extends('layouts.admin')

@section('title', __('Add Holiday'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.holiday.index') }}" class="hover:text-foreground">Holiday</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Holiday" description="Create a new holiday record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Holiday Information</x-card-title>
        <x-card-description>Fill in the details below to create a new holiday record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.holiday.store') }}" enctype="multipart/form-data">
            @csrf
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
                <x-button type="submit"><i class="fa fa-save"></i> Save Holiday</x-button>
                <x-button :href="route('admin.holiday.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
