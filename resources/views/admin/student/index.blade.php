@extends('layouts.admin')

@section('title', __('Student'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <span>Student</span>
@endsection

@section('content')
<x-page-header
    title="Student"
    description="Manage all student records"
>
    <x-button :href="route('admin.student.create')" size="sm">
        <i class="fa fa-plus"></i> Add New
    </x-button>
</x-page-header>

<x-card>
    <x-card-content class="p-0">
        <div class="border-b px-6 py-4">
            <h3 class="text-lg font-semibold">Student List</h3>
        </div>
        <div class="p-6">
            <table id="student-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Admission No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Class</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Section</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Father</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Mobile</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($records as $i => $record)
                    <tr>
                        <td class="px-4 py-3">{{ $record->admission_no ?? '-' }}</td>
                        <td class="px-4 py-3">{{ trim(($record->firstname ?? '') . ' ' . ($record->middlename ?? '') . ' ' . ($record->lastname ?? '')) }}</td>
                        <td class="px-4 py-3">{{{ $record->sessions->first()?->class?->class ?? '-' }}}</td>
                        <td class="px-4 py-3">{{{ $record->sessions->first()?->section?->section ?? '-' }}}</td>
                        <td class="px-4 py-3">{{ $record->father_name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $record->mobileno ?? '-' }}</td>
                        <td class="px-4 py-3"><x-badge :variant="$record->is_active ? 'success' : 'destructive'">{{ $record->is_active ? 'Active' : 'Inactive' }}</x-badge></td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.student.show', $record) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input hover:bg-accent" title="View">
                                    <i class="fa fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.student.edit', $record) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-input hover:bg-accent" title="Edit">
                                    <i class="fa fa-pencil text-sm"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.student.destroy', $record) }}" onsubmit="return confirmDelete()" class="inline-block">
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
                        <td colspan="8" class="px-4 py-12 text-center text-muted-foreground">
                            <i class="fa fa-inbox text-3xl mb-2"></i>
                            <p>No student records found.</p>
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
    window.initDataTable('#student-table', {
        order: [[0, 'desc']],
    });
});
</script>
@endpush
