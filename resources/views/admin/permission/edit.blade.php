@extends('layouts.admin')

@section('title', __('Permissions'))
@section('content_header', __('Edit Permissions'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Permissions') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.permission.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('name') ? 'has-error' : '' }">
                <label>{ __('Permission') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $record->name) }}">
                @error('name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.permission.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
