@extends('layouts.admin')

@section('title', __('Holidays'))
@section('content_header', __('Add Holidays'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Holidays') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.holiday.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('title') ? 'has-error' : '' }">
                <label>{ __('Title') }</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', old('title')) }}">
                @error('title')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('from_date') ? 'has-error' : '' }">
                <label>{ __('From Date') }</label>
                <input type="text" name="from_date" class="form-control datepicker" value="{{ old('from_date', old('from_date')) }}">
                @error('from_date')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('to_date') ? 'has-error' : '' }">
                <label>{ __('To Date') }</label>
                <input type="text" name="to_date" class="form-control datepicker" value="{{ old('to_date', old('to_date')) }}">
                @error('to_date')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('description') ? 'has-error' : '' }">
                <label>{ __('Description') }</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', old('description')) }}</textarea>
                @error('description')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.holiday.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
