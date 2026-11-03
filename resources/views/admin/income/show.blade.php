@extends('layouts.admin')

@section('title', __('Income Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.income.index') }}" class="hover:text-foreground">Income</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Income Details"
    description="View income record details"
>
    <x-button :href="route('admin.income.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.income.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Income Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Title</td>
                <td class="px-4 py-3 text-sm">{{ $record->name ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Invoice</td>
                <td class="px-4 py-3 text-sm">{{ $record->invoice_no ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Amount</td>
                <td class="px-4 py-3 text-sm">{{ formatCurrency($record->amount ?? 0) }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Date</td>
                <td class="px-4 py-3 text-sm">{{ formatDate($record->date) }}</td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
