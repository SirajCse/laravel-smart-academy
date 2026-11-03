@extends('layouts.admin')

@section('title', __('Add Inventory Item'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.inventory-item.index') }}" class="hover:text-foreground">Inventory Item</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Inventory Item" description="Create a new inventory item record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Inventory Item Information</x-card-title>
        <x-card-description>Fill in the details below to create a new inventory item record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.inventory-item.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Category">
                <x-select name="item_category_id" :options="[]" placeholder="Select category" />
            </x-form-field>
                <x-form-field label="Item Name">
                <x-input name="name" type="text" placeholder="Enter item name..." />
            </x-form-field>
                <x-form-field label="Item Code">
                <x-input name="item_code" type="text" placeholder="Enter item code..." />
            </x-form-field>
                <x-form-field label="Unit">
                <x-input name="unit" type="text" placeholder="Enter unit..." />
            </x-form-field>
                <x-form-field label="Purchase Price">
                <x-input name="purchase_price" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Sale Price">
                <x-input name="sale_price" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Opening Qty">
                <x-input name="opening_quantity" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Reorder Level">
                <x-input name="reorder_level" type="number" step="0.01" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Inventory Item</x-button>
                <x-button :href="route('admin.inventory-item.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
