@extends('layouts.auth')

@section('title', __('Admin Login'))

@section('content')
<p class="login-box-msg">{{ __('Sign in to start your session') }}</p>

<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <div class="form-group has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
        <input type="text" name="username" class="form-control" placeholder="{{ __('Username or Email') }}" value="{{ old('username') }}" autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @error('username')<span class="help-block">{{ $message }}</span>@enderror
    </div>
    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
        <input type="password" name="password" class="form-control" placeholder="{{ __('Password') }}">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @error('password')<span class="help-block">{{ $message }}</span>@enderror
    </div>
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}</label>
            </div>
        </div>
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Sign In') }}</button>
        </div>
    </div>
</form>

<div class="row" style="margin-top:15px;">
    <div class="col-xs-12 text-center">
        <a href="{{ route('admin.password.request') }}">{{ __('Forgot Your Password?') }}</a>
    </div>
</div>
@endsection
