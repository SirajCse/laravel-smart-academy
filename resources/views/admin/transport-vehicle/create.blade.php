@extends('layouts.admin')

@section('title', __('Add Transport Vehicle'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.transport-vehicle.index') }}" class="hover:text-foreground">Transport Vehicle</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Transport Vehicle" description="Create a new transport vehicle record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Transport Vehicle Information</x-card-title>
        <x-card-description>Fill in the details below to create a new transport vehicle record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.transport-vehicle.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Vehicle No">
                <x-input name="vehicle_no" type="text" placeholder="Enter vehicle no..." />
            </x-form-field>
                <x-form-field label="Vehicle Model">
                <x-input name="vehicle_model" type="text" placeholder="Enter vehicle model..." />
            </x-form-field>
                <x-form-field label="Driver Name">
                <x-input name="driver_name" type="text" placeholder="Enter driver name..." />
            </x-form-field>
                <x-form-field label="Driver Phone">
                <x-input name="driver_phone" type="text" placeholder="Enter driver phone..." />
            </x-form-field>
                <x-form-field label="Vehicle Fee">
                <x-input name="vehicle_fee" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Capacity">
                <x-input name="capacity" type="number" step="0.01" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Transport Vehicle</x-button>
                <x-button :href="route('admin.transport-vehicle.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
