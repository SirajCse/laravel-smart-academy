@extends('layouts.admin')

@section('title', __('Designations'))
@section('content_header', __('Add Designations'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Designations') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.designation.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('designation') ? 'has-error' : '' }">
                <label>{ __('Designation') }</label>
                <input type="text" name="designation" class="form-control" value="{{ old('designation', old('designation')) }}">
                @error('designation')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('description') ? 'has-error' : '' }">
                <label>{ __('Description') }</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', old('description')) }}</textarea>
                @error('description')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.designation.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
