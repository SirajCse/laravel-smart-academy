@extends('layouts.admin')

@section('title', __('Add Transport Route'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.transport-route.index') }}" class="hover:text-foreground">Transport Route</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Transport Route" description="Create a new transport route record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Transport Route Information</x-card-title>
        <x-card-description>Fill in the details below to create a new transport route record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.transport-route.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Route Title">
                <x-input name="route_title" type="text" placeholder="Enter route title..." />
            </x-form-field>
                <x-form-field label="Fare">
                <x-input name="fare" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="From Place">
                <x-input name="from_place" type="text" placeholder="Enter from place..." />
            </x-form-field>
                <x-form-field label="To Place">
                <x-input name="to_place" type="text" placeholder="Enter to place..." />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Transport Route</x-button>
                <x-button :href="route('admin.transport-route.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
