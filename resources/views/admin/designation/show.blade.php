@extends('layouts.admin')

@section('title', __('Designation Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.designation.index') }}" class="hover:text-foreground">Designation</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Designation Details"
    description="View designation record details"
>
    <x-button :href="route('admin.designation.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.designation.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Designation Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Designation</td>
                <td class="px-4 py-3 text-sm">{{ $record->designation ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Description</td>
                <td class="px-4 py-3 text-sm">{{ $record->description ?? '-' }}</td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
