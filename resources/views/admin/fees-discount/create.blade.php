@extends('layouts.admin')

@section('title', __('Fees Discounts'))
@section('content_header', __('Add Fees Discounts'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Fees Discounts') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.fees-discount.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('name') ? 'has-error' : '' }">
                <label>{ __('Name') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', old('name')) }}">
                @error('name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('code') ? 'has-error' : '' }">
                <label>{ __('Code') }</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', old('code')) }}">
                @error('code')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('amount') ? 'has-error' : '' }">
                <label>{ __('Amount') }</label>
                <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', old('amount')) }}">
                @error('amount')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.fees-discount.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
