@extends('layouts.admin')

@section('title', __('Add Homework'))
@section('content_header', __('Add New Homework'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Homework Information') }}</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.homework.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>{{ __('Class') }} <span class="text-red">*</span></label>
                    <select name="class_id" class="form-control select2" required>
                        <option value="">{{ __('Select Class') }}</option>
                        @foreach(\App\Models\SchoolClass::pluck('class','id') as $id => $name)
                            <option value="{{ $id }}" @if(old('class_id') == $id) selected @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>{{ __('Section') }} <span class="text-red">*</span></label>
                    <select name="section_id" class="form-control select2" required>
                        <option value="">{{ __('Select Section') }}</option>
                        @foreach(\App\Models\Section::pluck('section','id') as $id => $name)
                            <option value="{{ $id }}" @if(old('section_id') == $id) selected @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>{{ __('Subject') }} <span class="text-red">*</span></label>
                    <select name="subject_id" class="form-control select2" required>
                        <option value="">{{ __('Select Subject') }}</option>
                        @foreach(\App\Models\Subject::pluck('name','id') as $id => $name)
                            <option value="{{ $id }}" @if(old('subject_id') == $id) selected @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>{{ __('Homework Date') }} <span class="text-red">*</span></label>
                    <input type="text" name="homework_date" class="form-control datepicker" value="{{ old('homework_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 form-group">
                    <label>{{ __('Submit Date') }} <span class="text-red">*</span></label>
                    <input type="text" name="submit_date" class="form-control datepicker" value="{{ old('submit_date') }}" required>
                </div>
                <div class="col-md-4 form-group">
                    <label>{{ __('Marks') }}</label>
                    <input type="number" step="0.01" name="marks" class="form-control" value="{{ old('marks') }}">
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Description') }} <span class="text-red">*</span></label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label>{{ __('Attachment') }}</label>
                <input type="file" name="document" class="form-control">
            </div>
            <input type="hidden" name="session_id" value="{{ app(\App\Services\Customlib::class)->getActiveSessionId() }}">
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save Homework') }}</button>
                <a href="{{ route('admin.homework.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>$(function() { $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true }); $('.select2').select2(); });</script>
@endpush
