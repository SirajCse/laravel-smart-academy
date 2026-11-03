@extends('layouts.admin')

@section('title', __('Book Issue Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.book-issue.index') }}" class="hover:text-foreground">Book Issue</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Book Issue Details"
    description="View book issue record details"
>
    <x-button :href="route('admin.book-issue.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.book-issue.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Book Issue Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Book</td>
                <td class="px-4 py-3 text-sm">{{ $record?->book?->book_title ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Member</td>
                <td class="px-4 py-3 text-sm">{{ $record->member_id ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Issue Date</td>
                <td class="px-4 py-3 text-sm">{{ formatDate($record->issue_date) }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Return Date</td>
                <td class="px-4 py-3 text-sm">{{ formatDate($record->return_date) }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Returned</td>
                <td class="px-4 py-3"><x-badge :variant="$record->is_returned ? 'success' : 'secondary'">{{ $record->is_returned ? 'Yes' : 'No' }}</x-badge></td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
