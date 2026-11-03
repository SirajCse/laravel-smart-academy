@extends('layouts.admin')

@section('title', __('Add Fee Category'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.feecategory.index') }}" class="hover:text-foreground">Fee Category</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Fee Category" description="Create a new fee category record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Fee Category Information</x-card-title>
        <x-card-description>Fill in the details below to create a new fee category record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.feecategory.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Category Name">
                <x-input name="name" type="text" placeholder="Enter category name..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Fee Category</x-button>
                <x-button :href="route('admin.feecategory.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
