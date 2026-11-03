@extends('layouts.admin')

@section('title', __('Add Fee Session Group'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.feesessiongroup.index') }}" class="hover:text-foreground">Fee Session Group</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Fee Session Group" description="Create a new fee session group record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Fee Session Group Information</x-card-title>
        <x-card-description>Fill in the details below to create a new fee session group record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.feesessiongroup.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Session">
                <x-select name="session_id" :options="[]" placeholder="Select session" />
            </x-form-field>
                <x-form-field label="Fee Group Type">
                <x-select name="fee_groups_feetype_id" :options="[]" placeholder="Select fee group type" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Fee Session Group</x-button>
                <x-button :href="route('admin.feesessiongroup.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
