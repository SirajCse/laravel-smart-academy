@extends('layouts.admin')

@section('title', __('Addons'))
@section('content_header', __('Add Addons'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Addons') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.addons.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('name') ? 'has-error' : '' }">
                <label>{ __('Name') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', old('name')) }}">
                @error('name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('version') ? 'has-error' : '' }">
                <label>{ __('Version') }</label>
                <input type="text" name="version" class="form-control" value="{{ old('version', old('version')) }}">
                @error('version')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}> { __('Active') }</label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.addons.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
