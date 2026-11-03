@extends('layouts.admin')

@section('title', __('Student Fees Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.student-fee.index') }}" class="hover:text-foreground">Student Fees</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Student Fees Details"
    description="View student fees record details"
>
    <x-button :href="route('admin.student-fee.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.student-fee.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Student Fees Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Student</td>
                <td class="px-4 py-3 text-sm">{{ $record?->studentSession?->student?->firstname ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Fee Type</td>
                <td class="px-4 py-3 text-sm">{{ $record?->feeSessionGroup?->groupType?->type?->name ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Amount</td>
                <td class="px-4 py-3 text-sm">{{ formatCurrency($record->amount ?? 0) }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Paid</td>
                <td class="px-4 py-3 text-sm">{{ formatCurrency($record->payments ?? 0) }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Discount</td>
                <td class="px-4 py-3 text-sm">{{ formatCurrency($record->discount_amount ?? 0) }}</td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
