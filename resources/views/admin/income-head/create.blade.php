@extends('layouts.admin')

@section('title', __('Add Income Head'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.income-head.index') }}" class="hover:text-foreground">Income Head</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Income Head" description="Create a new income head record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Income Head Information</x-card-title>
        <x-card-description>Fill in the details below to create a new income head record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.income-head.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Income Category">
                <x-input name="income_category" type="text" placeholder="Enter income category..." />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Income Head</x-button>
                <x-button :href="route('admin.income-head.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
