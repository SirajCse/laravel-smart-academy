@extends('layouts.admin')

@section('title', __('Visitors'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <span>Visitors</span>
@endsection

@section('content')
<x-page-header
    title="Visitors"
    description="Visitor log and front office activity"
/>

<x-card>
    <x-card-content class="p-0">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold">Visitor List</h3>
        </div>
        <div class="p-6">
            <table id="visitors-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Purpose</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $i => $record)
                    <tr>
                        <td class="px-4 py-3">{{ $i+1 }}</td>
                        <td class="px-4 py-3">{{ $record->name }}</td>
                        <td class="px-4 py-3">{{ $record->purpose }}</td>
                        <td class="px-4 py-3">{{ $record->phone }}</td>
                        <td class="px-4 py-3">{{ formatDate($record->date) }}</td>
                        <td class="px-4 py-3"><x-badge :variant="$record->status === 'closed' ? 'secondary' : 'info'">{{ $record->status }}</x-badge></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-muted-foreground">
                            <i class="fa fa-inbox text-3xl mb-2"></i>
                            <p>No visitor records found.</p>
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
    window.initDataTable('#visitors-table', { order: [[4, 'desc']] });
});
</script>
@endpush
