@extends('layouts.admin')

@section('title', __('Sections'))
@section('content_header', __('Add Sections'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Sections') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.section.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('section') ? 'has-error' : '' }">
                <label>{ __('Section Name') }</label>
                <input type="text" name="section" class="form-control" value="{{ old('section', old('section')) }}">
                @error('section')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('note') ? 'has-error' : '' }">
                <label>{ __('Note') }</label>
                <textarea name="note" class="form-control" rows="3">{{ old('note', old('note')) }}</textarea>
                @error('note')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.section.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
