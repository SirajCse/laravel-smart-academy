@extends('layouts.admin')

@section('title', __('Sessions'))
@section('content_header', __('Add Sessions'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Sessions') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.session.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('session') ? 'has-error' : '' }">
                <label>{ __('Session Year') }</label>
                <input type="text" name="session" class="form-control" value="{{ old('session', old('session')) }}">
                @error('session')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}> { __('Active') }</label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.session.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
