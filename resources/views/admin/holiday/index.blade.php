@extends('layouts.admin')

@section('title', __('Holiday'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <span>Holiday</span>
@endsection

@section('content')
<x-page-header
    title="Holiday"
    description="Manage all holiday records"
>
    <x-button :href="route('admin.holiday.create')" size="sm">
        <i class="fa fa-plus"></i> Add New
    </x-button>
</x-page-header>

<x-card>
    <x-card-content class="p-0">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold">Holiday List</h3>
        </div>
        <div class="p-6">
            <table id="holiday-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">From</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">To</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $i => $record)
                    <tr>
                        <td class="px-4 py-3">{{ $record->title ?? '-' }}</td>
                        <td class="px-4 py-3">{{ formatDate($record->from_date) }}</td>
                        <td class="px-4 py-3">{{ formatDate($record->to_date) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.holiday.show', $record) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input hover:bg-accent" title="View">
                                    <i class="fa fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.holiday.edit', $record) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input hover:bg-accent" title="Edit">
                                    <i class="fa fa-pencil text-sm"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.holiday.destroy', $record) }}" onsubmit="return confirmDelete()" class="inline-block">
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
                        <td colspan="4" class="px-4 py-12 text-center text-muted-foreground">
                            <i class="fa fa-inbox text-3xl mb-2"></i>
                            <p>No holiday records found.</p>
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
    window.initDataTable('#holiday-table', {
        order: [[0, 'desc']],
    });
});
</script>
@endpush
