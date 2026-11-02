@extends('layouts.admin')

@section('title', __('Staff Login'))
@section('content_header', __('Staff Login'))

@section('content')
<div class="login-box col-md-4 col-md-offset-4">
    <div class="box box-primary">
        <div class="box-header with-border"><h3 class="box-title">{{ __('Staff Login') }}</h3></div>
        <div class="box-body">
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="form-group has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
                    <label>{{ __('Username or Email') }}</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" autofocus required>
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label>{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('Sign In') }}</button>
            </form>
            <p class="text-center" style="margin-top: 15px;">
                <a href="{{ route('student.login') }}">{{ __('Student Login') }}</a> |
                <a href="{{ route('admin.password.request') }}">{{ __('Forgot Password?') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection
