@extends('layouts.admin')

@section('title', __('Enquiries'))
@section('content_header', __('Edit Enquiries'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Edit Enquiries') }</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.enquiry.update', $record) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group { $errors->has('name') ? 'has-error' : '' }">
                <label>{ __('Name') }</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $record->name) }}">
                @error('name')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('email') ? 'has-error' : '' }">
                <label>{ __('Email') }</label>
                <input type="text" name="email" class="form-control" value="{{ old('email', $record->email) }}">
                @error('email')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('phone') ? 'has-error' : '' }">
                <label>{ __('Phone') }</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $record->phone) }}">
                @error('phone')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('purpose') ? 'has-error' : '' }">
                <label>{ __('Purpose') }</label>
                <input type="text" name="purpose" class="form-control" value="{{ old('purpose', $record->purpose) }}">
                @error('purpose')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('date') ? 'has-error' : '' }">
                <label>{ __('Date') }</label>
                <input type="text" name="date" class="form-control datepicker" value="{{ old('date', $record->date) }}">
                @error('date')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group { $errors->has('status') ? 'has-error' : '' }">
                <label>{ __('Status') }</label>
                <input type="text" name="status" class="form-control" value="{{ old('status', $record->status) }}">
                @error('status')<span class="help-block">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> { __('Save') }</button>
                <a href="{{ route('admin.enquiry.index') }}" class="btn btn-default">{ __('Cancel') }</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });</script>
@endpush
