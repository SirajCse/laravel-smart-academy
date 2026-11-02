@extends('layouts.auth')

@section('title', __('Forgot Password'))

@section('content')
<p class="login-box-msg">{{ __('Reset Your Password') }}</p>
<form method="POST" action="{{ route('student.password.email') }}">
    @csrf
    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
        <label>{{ __('Email Address') }}</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        @error('email')<span class="help-block">{{ $message }}</span>@enderror
    </div>
    <button type="submit" class="btn btn-primary btn-block">{{ __('Send Reset Link') }}</button>
</form>
<p class="text-center" style="margin-top: 15px;"><a href="{{ route('student.login') }}">{{ __('Back to Login') }}</a></p>
@endsection
