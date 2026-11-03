@extends('layouts.admin')

@section('title', __('Add Hostel Room'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.hostel-room.index') }}" class="hover:text-foreground">Hostel Room</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Hostel Room" description="Create a new hostel room record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Hostel Room Information</x-card-title>
        <x-card-description>Fill in the details below to create a new hostel room record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.hostel-room.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Hostel">
                <x-select name="hostel_id" :options="[]" placeholder="Select hostel" />
            </x-form-field>
                <x-form-field label="Room Type">
                <x-select name="room_type" :options="['single' => 'Single', 'double' => 'Double', 'triple' => 'Triple', 'dormitory' => 'Dormitory']" placeholder="Select room type" />
            </x-form-field>
                <x-form-field label="Room No">
                <x-input name="room_no" type="text" placeholder="Enter room no..." />
            </x-form-field>
                <x-form-field label="Number of Beds">
                <x-input name="no_of_bed" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Cost per Bed">
                <x-input name="cost_per_bed" type="number" step="0.01" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Hostel Room</x-button>
                <x-button :href="route('admin.hostel-room.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
