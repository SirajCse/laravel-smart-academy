@extends('layouts.admin')

@section('title', __('Roles'))
@section('content_header', __('Edit Roles'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Roles') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.role.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('name') ? 'has-error' : '' }">
                <label>{ __('Role Name') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $record->name) }}">
                @error('name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('description') ? 'has-error' : '' }">
                <label>{ __('Description') }</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $record->description) }}</textarea>
                @error('description')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.role.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
