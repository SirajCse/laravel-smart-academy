@extends('layouts.student')

@section('title', __('My Profile'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Profile Information') }}</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('student.profile') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{ $currentUser->image ? asset('storage/'.$currentUser->image) : asset('backend/dist/img/avatar.png') }}" class="img-circle img-responsive" style="max-width: 150px;">
                    <input type="file" name="image" class="form-control" accept="image/*" style="margin-top: 10px;">
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $currentUser->name) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $currentUser->email) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $currentUser->phone) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ __('Address') }}</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $currentUser->address) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save Changes') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
