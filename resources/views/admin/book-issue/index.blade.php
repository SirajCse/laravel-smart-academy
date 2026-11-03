@extends('layouts.admin')

@section('title', __('Book Issue'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <span>Book Issue</span>
@endsection

@section('content')
<x-page-header
    title="Book Issue"
    description="Manage all book issue records"
>
    <x-button :href="route('admin.book-issue.create')" size="sm">
        <i class="fa fa-plus"></i> Add New
    </x-button>
</x-page-header>

<x-card>
    <x-card-content class="p-0">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold">Book Issue List</h3>
        </div>
        <div class="p-6">
            <table id="book_issue-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Book</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Member</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Issue Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Return Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Returned</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $i => $record)
                    <tr>
                        <td class="px-4 py-3">{{ $record->book.book_title ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $record->member_id ?? '-' }}</td>
                        <td class="px-4 py-3">{{ formatDate($record->issue_date) }}</td>
                        <td class="px-4 py-3">{{ formatDate($record->return_date) }}</td>
                        <td class="px-4 py-3"><x-badge :variant="$record->is_returned ? 'success' : 'destructive'">{{ $record->is_returned ? 'Active' : 'Inactive' }}</x-badge></td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.book-issue.show', $record) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input hover:bg-accent" title="View">
                                    <i class="fa fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.book-issue.edit', $record) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input hover:bg-accent" title="Edit">
                                    <i class="fa fa-pencil text-sm"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.book-issue.destroy', $record) }}" onsubmit="return confirmDelete()" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input text-destructive hover:bg-destructive/10" title="Delete">
                                        <i class="fa fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-muted-foreground">
                            <i class="fa fa-inbox text-3xl mb-2"></i>
                            <p>No book issue records found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card-content>
</x-card>
@endsection

@push('scripts')
<script>
$(function() {
    window.initDataTable('#book_issue-table', {
        order: [[0, 'desc']],
    });
});
</script>
@endpush
