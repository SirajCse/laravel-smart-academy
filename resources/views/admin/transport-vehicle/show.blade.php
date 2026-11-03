@extends('layouts.admin')

@section('title', __('Transport Vehicle Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.transport-vehicle.index') }}" class="hover:text-foreground">Transport Vehicle</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Transport Vehicle Details"
    description="View transport vehicle record details"
>
    <x-button :href="route('admin.transport-vehicle.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.transport-vehicle.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Transport Vehicle Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Vehicle No</td>
                <td class="px-4 py-3 text-sm">{{ $record->vehicle_no ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Driver</td>
                <td class="px-4 py-3 text-sm">{{ $record->driver_name ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Fee</td>
                <td class="px-4 py-3 text-sm">{{ formatCurrency($record->vehicle_fee ?? 0) }}</td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
