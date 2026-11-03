@extends('layouts.admin')

@section('title', __('Add Expense Head'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.expense-head.index') }}" class="hover:text-foreground">Expense Head</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Expense Head" description="Create a new expense head record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Expense Head Information</x-card-title>
        <x-card-description>Fill in the details below to create a new expense head record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.expense-head.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Expense Category">
                <x-input name="expense_category" type="text" placeholder="Enter expense category..." />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Expense Head</x-button>
                <x-button :href="route('admin.expense-head.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
