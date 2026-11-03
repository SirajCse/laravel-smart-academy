@extends('layouts.admin')

@section('title', __('Front CMS Menu Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.frontcms-menu.index') }}" class="hover:text-foreground">Front CMS Menu</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Front CMS Menu Details"
    description="View front cms menu record details"
>
    <x-button :href="route('admin.frontcms-menu.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.frontcms-menu.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Front CMS Menu Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Title</td>
                <td class="px-4 py-3 text-sm">{{ $record->title ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">URL</td>
                <td class="px-4 py-3 text-sm">{{ $record->url ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Order</td>
                <td class="px-4 py-3 text-sm">{{ $record->order ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Status</td>
                <td class="px-4 py-3"><x-badge :variant="$record->is_active ? 'success' : 'secondary'">{{ $record->is_active ? 'Yes' : 'No' }}</x-badge></td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
