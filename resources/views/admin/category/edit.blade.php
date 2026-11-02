@extends('layouts.admin')

@section('title', __('Categories'))
@section('content_header', __('Edit Categories'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Categories') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.category.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('category') ? 'has-error' : '' }">
                <label>{ __('Category Name') }</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $record->category) }}">
                @error('category')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('description') ? 'has-error' : '' }">
                <label>{ __('Description') }</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $record->description) }}</textarea>
                @error('description')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.category.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
