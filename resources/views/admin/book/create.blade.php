@extends('layouts.admin')

@section('title', __('Books'))
@section('content_header', __('Add Books'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Books') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.book.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('book_title') ? 'has-error' : '' }">
                <label>{ __('Title') }</label>
                <input type="text" name="book_title" class="form-control" value="{{ old('book_title', old('book_title')) }}">
                @error('book_title')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('book_no') ? 'has-error' : '' }">
                <label>{ __('Book No') }</label>
                <input type="text" name="book_no" class="form-control" value="{{ old('book_no', old('book_no')) }}">
                @error('book_no')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('author') ? 'has-error' : '' }">
                <label>{ __('Author') }</label>
                <input type="text" name="author" class="form-control" value="{{ old('author', old('author')) }}">
                @error('author')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('qty') ? 'has-error' : '' }">
                <label>{ __('Quantity') }</label>
                <input type="number" step="0.01" name="qty" class="form-control" value="{{ old('qty', old('qty')) }}">
                @error('qty')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.book.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
