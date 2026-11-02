@extends('layouts.admin')

@section('title', __('Expense'))
@section('content_header', __('Edit Expense'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Expense') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.expense.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('name') ? 'has-error' : '' }">
                <label>{ __('Title') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $record->name) }}">
                @error('name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('invoice_no') ? 'has-error' : '' }">
                <label>{ __('Invoice No') }</label>
                <input type="text" name="invoice_no" class="form-control" value="{{ old('invoice_no', $record->invoice_no) }}">
                @error('invoice_no')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('amount') ? 'has-error' : '' }">
                <label>{ __('Amount') }</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $record->amount) }}">
                @error('amount')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('date') ? 'has-error' : '' }">
                <label>{ __('Date') }</label>
                <input type="text" name="date" class="form-control datepicker" value="{{ old('date', $record->date) }}">
                @error('date')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.expense.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
