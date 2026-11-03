@extends('layouts.admin')

@section('title', __('Category Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.category.index') }}" class="hover:text-foreground">Category</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Category Details"
    description="View category record details"
>
    <x-button :href="route('admin.category.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.category.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Category Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Category</td>
                <td class="px-4 py-3 text-sm">{{ $record->category ?? '-' }}</td>
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
