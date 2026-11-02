@extends('layouts.admin')

@section('title', __('Currencies'))
@section('content_header', __('Edit Currencies'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Currencies') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.currency.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('currency') ? 'has-error' : '' }">
                <label>{ __('Currency') }</label>
                <input type="text" name="currency" class="form-control" value="{{ old('currency', $record->currency) }}">
                @error('currency')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('symbol') ? 'has-error' : '' }">
                <label>{ __('Symbol') }</label>
                <input type="text" name="symbol" class="form-control" value="{{ old('symbol', $record->symbol) }}">
                @error('symbol')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('placement') ? 'has-error' : '' }">
                <label>{ __('Placement') }</label>
                <input type="text" name="placement" class="form-control" value="{{ old('placement', $record->placement) }}">
                @error('placement')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.currency.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
