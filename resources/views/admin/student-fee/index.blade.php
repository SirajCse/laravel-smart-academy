@extends('layouts.admin')

@section('title', __('Student Fees'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <span>Student Fees</span>
@endsection

@section('content')
<x-page-header
    title="Student Fees"
    description="Manage all student fees records"
>
    <x-button :href="route('admin.student-fee.create')" size="sm">
        <i class="fa fa-plus"></i> Add New
    </x-button>
</x-page-header>

<x-card>
    <x-card-content class="p-0">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold">Student Fees List</h3>
        </div>
        <div class="p-6">
            <table id="student_fee-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Fee Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Paid</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Discount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $i => $record)
                    <tr>
                        <td class="px-4 py-3">{{ $record->studentSession.student.firstname ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $record->feeSessionGroup.groupType.type.name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ formatCurrency($record->amount ?? 0) }}</td>
                        <td class="px-4 py-3">{{ formatCurrency($record->payments ?? 0) }}</td>
                        <td class="px-4 py-3">{{ formatCurrency($record->discount_amount ?? 0) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.student-fee.show', $record) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input hover:bg-accent" title="View">
                                    <i class="fa fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.student-fee.edit', $record) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input hover:bg-accent" title="Edit">
                                    <i class="fa fa-pencil text-sm"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.student-fee.destroy', $record) }}" onsubmit="return confirmDelete()" class="inline-block">
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
                            <p>No student fees records found.</p>
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
    window.initDataTable('#student_fee-table', {
        order: [[0, 'desc']],
    });
});
</script>
@endpush
