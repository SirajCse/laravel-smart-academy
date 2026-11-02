@extends('layouts.admin')

@section('title', __('Audit Logs'))
@section('content_header', __('Edit Audit Logs'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Audit Logs') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.audit.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('module') ? 'has-error' : '' }">
                <label>{ __('Module') }</label>
                <input type="text" name="module" class="form-control" value="{{ old('module', $record->module) }}">
                @error('module')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('action') ? 'has-error' : '' }">
                <label>{ __('Action') }</label>
                <input type="text" name="action" class="form-control" value="{{ old('action', $record->action) }}">
                @error('action')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('message') ? 'has-error' : '' }">
                <label>{ __('Message') }</label>
                <textarea name="message" class="form-control" rows="3">{{ old('message', $record->message) }}</textarea>
                @error('message')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.audit.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
