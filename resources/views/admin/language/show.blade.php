@extends('layouts.admin')

@section('title', __('Language Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.language.index') }}" class="hover:text-foreground">Language</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Language Details"
    description="View language record details"
>
    <x-button :href="route('admin.language.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.language.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Language Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Language</td>
                <td class="px-4 py-3 text-sm">{{ $record->language ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Code</td>
                <td class="px-4 py-3 text-sm">{{ $record->short_code ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">RTL</td>
                <td class="px-4 py-3"><x-badge :variant="$record->is_rtl ? 'success' : 'secondary'">{{ $record->is_rtl ? 'Yes' : 'No' }}</x-badge></td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
