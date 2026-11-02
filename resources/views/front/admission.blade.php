@extends('layouts.front')

@section('title', __('Online Admission'))

@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('Online Admission Form') }}</h3></div>
            <div class="panel-body">
                <form method="POST" action="{{ route('page.admission.submit') }}" enctype="multipart/form-data">
                    @csrf

                    <h4>{{ __('Personal Information') }}</h4>
                    <div class="row">
                        <div class="col-md-4 form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                            <label>{{ __('First Name') }} <span class="text-red">*</span></label>
                            <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>{{ __('Middle Name') }}</label>
                            <input type="text" name="middlename" class="form-control" value="{{ old('middlename') }}">
                        </div>
                        <div class="col-md-4 form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                            <label>{{ __('Last Name') }} <span class="text-red">*</span></label>
                            <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>{{ __('Date of Birth') }}</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label>{{ __('Gender') }}</label>
                            <select name="gender" class="form-control">
                                @foreach(genderList() as $k => $v)
                                    <option value="{{ $k }}" @if(old('gender') === $k) selected @endif>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>{{ __('Class Applying For') }}</label>
                            <select name="class_id" class="form-control" required>
                                <option value="">{{ __('Select') }}</option>
                                @foreach(getClasses() as $id => $name)
                                    <option value="{{ $id }}" @if(old('class_id') == $id) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h4>{{ __('Contact Information') }}</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <h4>{{ __('Guardian Information') }}</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('Father Name') }}</label>
                            <input type="text" name="father_name" class="form-control" value="{{ old('father_name') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Mother Name') }}</label>
                            <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Address') }}</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Submit Application') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
