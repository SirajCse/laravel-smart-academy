@extends('layouts.admin')

@section('title', __('Enquiry Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.enquiry.index') }}" class="hover:text-foreground">Enquiry</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Enquiry Details"
    description="View enquiry record details"
>
    <x-button :href="route('admin.enquiry.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.enquiry.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Enquiry Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Name</td>
                <td class="px-4 py-3 text-sm">{{ $record->name ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Email</td>
                <td class="px-4 py-3 text-sm">{{ $record->email ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Phone</td>
                <td class="px-4 py-3 text-sm">{{ $record->phone ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Purpose</td>
                <td class="px-4 py-3 text-sm">{{ $record->purpose ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Date</td>
                <td class="px-4 py-3 text-sm">{{ formatDate($record->date) }}</td>
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
