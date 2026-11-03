@extends('layouts.admin')

@section('title', __('Edit Fee Type'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.feetype.index') }}" class="hover:text-foreground">Fee Type</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit Fee Type" description="Update the fee type record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Fee Type Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.feetype.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Category">
                <x-select name="feecategory_id" :options="[]" placeholder="Select category" />
            </x-form-field>
                <x-form-field label="Code">
                <x-input name="code" type="text" placeholder="Enter code..." />
            </x-form-field>
                <x-form-field label="Name">
                <x-input name="name" type="text" placeholder="Enter name..." />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.feetype.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
