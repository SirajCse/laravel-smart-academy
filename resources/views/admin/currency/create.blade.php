@extends('layouts.admin')

@section('title', __('Add Currency'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.currency.index') }}" class="hover:text-foreground">Currency</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Currency" description="Create a new currency record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Currency Information</x-card-title>
        <x-card-description>Fill in the details below to create a new currency record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.currency.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Currency">
                <x-input name="currency" type="text" placeholder="Enter currency..." />
            </x-form-field>
                <x-form-field label="Symbol">
                <x-input name="symbol" type="text" placeholder="Enter symbol..." />
            </x-form-field>
                <x-form-field label="Placement">
                <x-select name="placement" :options="['before' => 'Before Amount', 'after' => 'After Amount']" placeholder="Select placement" />
            </x-form-field>
                <x-form-field label="Exchange Rate">
                <x-input name="exchange_rate" type="number" step="0.01" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Currency</x-button>
                <x-button :href="route('admin.currency.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
