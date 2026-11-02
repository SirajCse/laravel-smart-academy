@extends('layouts.admin')

@section('title', __('Languages'))
@section('content_header', __('Edit Languages'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Languages') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.language.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('language') ? 'has-error' : '' }">
                <label>{ __('Language Name') }</label>
                <input type="text" name="language" class="form-control" value="{{ old('language', $record->language) }}">
                @error('language')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('short_code') ? 'has-error' : '' }">
                <label>{ __('Short Code') }</label>
                <input type="text" name="short_code" class="form-control" value="{{ old('short_code', $record->short_code) }}">
                @error('short_code')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_rtl" value="1" {{ old('is_rtl', $record->is_rtl) ? 'checked' : '' }}> { __('RTL') }</label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.language.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
