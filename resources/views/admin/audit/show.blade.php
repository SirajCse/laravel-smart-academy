@extends('layouts.admin')

@section('title', __('Audit Log Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.audit.index') }}" class="hover:text-foreground">Audit Log</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Audit Log Details"
    description="View audit log record details"
>
    <x-button :href="route('admin.audit.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.audit.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Audit Log Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Module</td>
                <td class="px-4 py-3 text-sm">{{ $record->module ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Action</td>
                <td class="px-4 py-3 text-sm">{{ $record->action ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Message</td>
                <td class="px-4 py-3 text-sm">{{ $record->message ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Date</td>
                <td class="px-4 py-3 text-sm">{{ $record->created_at?->format('d-m-Y H:i') }}</td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
