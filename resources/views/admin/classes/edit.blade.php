@extends('layouts.admin')

@section('title', __('Classes'))
@section('content_header', __('Edit Classes'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Classes') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.class.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('class') ? 'has-error' : '' }">
                <label>{ __('Class Name') }</label>
                <input type="text" name="class" class="form-control" value="{{ old('class', $record->class) }}">
                @error('class')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('note') ? 'has-error' : '' }">
                <label>{ __('Note') }</label>
                <textarea name="note" class="form-control" rows="3">{{ old('note', $record->note) }}</textarea>
                @error('note')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $record->is_active) ? 'checked' : '' }}> { __('Status') }</label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.class.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
