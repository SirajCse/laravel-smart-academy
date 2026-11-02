@extends('layouts.admin')

@section('title', __('Add Content'))
@section('content_header', __('Add New Content'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Content Information') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.content.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>{ __('Name') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label>{ __('Description') }</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.content.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection
