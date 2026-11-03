@extends('layouts.admin')

@section('title', __('Inventory Item Details'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.inventory-item.index') }}" class="hover:text-foreground">Inventory Item</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Details</span>
@endsection

@section('content')
<x-page-header
    title="Inventory Item Details"
    description="View inventory item record details"
>
    <x-button :href="route('admin.inventory-item.edit', $record)" variant="outline" size="sm">
        <i class="fa fa-pencil"></i> Edit
    </x-button>
    <x-button :href="route('admin.inventory-item.index')" variant="ghost" size="sm">
        <i class="fa fa-arrow-left"></i> Back to List
    </x-button>
</x-page-header>

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Inventory Item Information</x-card-title>
    </x-card-header>
    <x-card-content>
        <table class="w-full">
            <tbody>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Name</td>
                <td class="px-4 py-3 text-sm">{{ $record->name ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Code</td>
                <td class="px-4 py-3 text-sm">{{ $record->item_code ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Qty</td>
                <td class="px-4 py-3 text-sm">{{ $record->current_quantity ?? '-' }}</td>
            </tr>
                <tr class="border-b last:border-0">
                <td class="px-4 py-3 text-sm font-medium text-muted-foreground" style="width:30%">Sale Price</td>
                <td class="px-4 py-3 text-sm">{{ formatCurrency($record->sale_price ?? 0) }}</td>
            </tr>
            </tbody>
        </table>
    </x-card-content>
</x-card>
@endsection
