@extends('layouts.admin')

@section('title', __('Add Income'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.income.index') }}" class="hover:text-foreground">Income</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Income" description="Create a new income record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Income Information</x-card-title>
        <x-card-description>Fill in the details below to create a new income record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.income.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Income Head">
                <x-select name="income_head_id" :options="[]" placeholder="Select income head" />
            </x-form-field>
                <x-form-field label="Title">
                <x-input name="name" type="text" placeholder="Enter title..." />
            </x-form-field>
                <x-form-field label="Invoice No">
                <x-input name="invoice_no" type="text" placeholder="Enter invoice no..." />
            </x-form-field>
                <x-form-field label="Amount">
                <x-input name="amount" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Date">
                <x-input name="date" type="date" />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
                <x-form-field label="Payment Mode">
                <x-select name="payment_mode" :options="['cash' => 'Cash', 'cheque' => 'Cheque', 'dd' => 'DD', 'bank_transfer' => 'Bank Transfer', 'online' => 'Online']" placeholder="Select payment mode" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Income</x-button>
                <x-button :href="route('admin.income.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
