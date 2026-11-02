@extends('layouts.admin')

@section('title', __('Subjects'))
@section('content_header', __('Add Subjects'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Subjects') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.subject.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('name') ? 'has-error' : '' }">
                <label>{ __('Subject Name') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', old('name')) }}">
                @error('name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('code') ? 'has-error' : '' }">
                <label>{ __('Code') }</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', old('code')) }}">
                @error('code')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('type') ? 'has-error' : '' }">
                <label>{ __('Type') }</label>
                <input type="text" name="type" class="form-control" value="{{ old('type', old('type')) }}">
                @error('type')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.subject.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
