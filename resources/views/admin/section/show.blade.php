@extends('layouts.admin')

@section('title', __('Section Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.section.index') }}" class="hover:text-foreground">Section</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Section Details"
    description="View section record details"
>
    <x-button :href="route('admin.section.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.section.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Section Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Section</td>
                <td class="px-4 py-3 text-sm">{{ $record->section ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Note</td>
                <td class="px-4 py-3 text-sm">{{ $record->note ?? '-' }}</td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
