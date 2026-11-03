@extends('layouts.admin')

@section('title', __('Apply Leave Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.apply-leave.index') }}" class="hover:text-foreground">Apply Leave</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Apply Leave Details"
    description="View apply leave record details"
>
    <x-button :href="route('admin.apply-leave.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.apply-leave.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Apply Leave Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Apply Date</td>
                <td class="px-4 py-3 text-sm">{{ formatDate($record->apply_date) }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">From</td>
                <td class="px-4 py-3 text-sm">{{ formatDate($record->leave_from) }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">To</td>
                <td class="px-4 py-3 text-sm">{{ formatDate($record->leave_to) }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Reason</td>
                <td class="px-4 py-3 text-sm">{{ $record->reason ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Status</td>
                <td class="px-4 py-3"><x-badge :variant="$record->status ? 'success' : 'secondary'">{{ $record->status ? 'Yes' : 'No' }}</x-badge></td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
