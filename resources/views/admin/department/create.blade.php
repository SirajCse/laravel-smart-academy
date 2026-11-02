@extends('layouts.admin')

@section('title', __('Departments'))
@section('content_header', __('Add Departments'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Departments') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.department.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('department_name') ? 'has-error' : '' }">
                <label>{ __('Name') }</label>
                <input type="text" name="department_name" class="form-control" value="{{ old('department_name', old('department_name')) }}">
                @error('department_name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('description') ? 'has-error' : '' }">
                <label>{ __('Description') }</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', old('description')) }}</textarea>
                @error('description')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.department.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
