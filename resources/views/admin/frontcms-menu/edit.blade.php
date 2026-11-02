@extends('layouts.admin')

@section('title', __('Edit Frontcms Menu'))
@section('content_header', __('Edit Frontcms Menu'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Frontcms Menu Information') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.frontcms-menu.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label>{ __('Name') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $record->name ?? '') }}">
            </div>
            <div class="form-group">
                <label>{ __('Description') }</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $record->description ?? '') }}</textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.frontcms-menu.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection
