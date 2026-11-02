@extends('layouts.admin')

@section('title', __('School Settings'))
@section('content_header', __('Manage School Settings'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('School Information') }}</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.schsettings.index') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>{{ __('School Name') }} <span class="text-red">*</span></label>
                    <input type="text" name="school_name" class="form-control" value="{{ old('school_name', $record->school_name) }}" required>
                </div>
                <div class="col-md-6 form-group">
                    <label>{{ __('School Code') }}</label>
                    <input type="text" name="school_code" class="form-control" value="{{ old('school_code', $record->school_code) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>{{ __('Email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $record->email) }}">
                </div>
                <div class="col-md-6 form-group">
                    <label>{{ __('Phone') }}</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $record->phone) }}">
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Address') }}</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $record->address) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>{{ __('Currency') }}</label>
                    <input type="text" name="currency" class="form-control" value="{{ old('currency', $record->currency) }}">
                </div>
                <div class="col-md-4 form-group">
                    <label>{{ __('Currency Symbol') }}</label>
                    <input type="text" name="currency_symbol" class="form-control" value="{{ old('currency_symbol', $record->currency_symbol) }}">
                </div>
                <div class="col-md-4 form-group">
                    <label>{{ __('Date Format') }}</label>
                    <select name="date_format" class="form-control">
                        @foreach(['d-m-Y', 'm-d-Y', 'Y-m-d', 'd/m/Y', 'm/d/Y', 'Y/m/d'] as $fmt)
                            <option value="{{ $fmt }}" @if($record->date_format === $fmt) selected @endif>{{ $fmt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>{{ __('Theme') }}</label>
                    <select name="theme" class="form-control">
                        @foreach(['default', 'bold_blue', 'darkgray', 'material_pink', 'shadow_white', 'yellow'] as $t)
                            <option value="{{ $t }}" @if($record->theme === $t) selected @endif>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>{{ __('Timezone') }}</label>
                    <input type="text" name="timezone" class="form-control" value="{{ old('timezone', $record->timezone) }}">
                </div>
                <div class="col-md-4 form-group">
                    <label>{{ __('Office Hours') }}</label>
                    <input type="text" name="office_hours" class="form-control" value="{{ old('office_hours', $record->office_hours) }}">
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('Copyright Text') }}</label>
                <input type="text" name="copyright" class="form-control" value="{{ old('copyright', $record->copyright) }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save Settings') }}</button>
                <a href="{{ route('admin.schsettings.backup') }}" class="btn btn-default"><i class="fa fa-database"></i> {{ __('Backup') }}</a>
                <a href="{{ route('admin.schsettings.audit') }}" class="btn btn-info"><i class="fa fa-history"></i> {{ __('Audit Log') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
