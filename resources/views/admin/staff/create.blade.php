@extends('layouts.admin')

@section('title', __('Staff'))
@section('content_header', __('Add Staff'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Add Staff') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group { $errors->has('name') ? 'has-error' : '' }">
                <label>{ __('Name') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', old('name')) }}">
                @error('name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('email') ? 'has-error' : '' }">
                <label>{ __('Email') }</label>
                <input type="text" name="email" class="form-control" value="{{ old('email', old('email')) }}">
                @error('email')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('phone') ? 'has-error' : '' }">
                <label>{ __('Phone') }</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', old('phone')) }}">
                @error('phone')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('gender') ? 'has-error' : '' }">
                <label>{ __('Gender') }</label>
                <select name="gender" class="form-control select2">
                    <option value="">{ __('Select') }</option>
                </select>
                @error('gender')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('dob') ? 'has-error' : '' }">
                <label>{ __('Date of Birth') }</label>
                <input type="text" name="dob" class="form-control datepicker" value="{{ old('dob', old('dob')) }}">
                @error('dob')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('joining_date') ? 'has-error' : '' }">
                <label>{ __('Joining Date') }</label>
                <input type="text" name="joining_date" class="form-control datepicker" value="{{ old('joining_date', old('joining_date')) }}">
                @error('joining_date')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('image') ? 'has-error' : '' }">
                <label>{ __('Photo') }</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @if(isset($image_url))
                    <img src="{{ $image_url }}" class="img-thumbnail" style="max-width: 150px; margin-top: 10px;">
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.staff.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
