@extends('layouts.auth')

@section('title', __('Reset Password'))

@section('content')
<p class="login-box-msg">{{ __('Reset Your Password') }}</p>
<form method="POST" action="{{ route('student.password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
        <label>{{ __('New Password') }}</label>
        <input type="password" name="password" class="form-control" required>
        @error('password')<span class="help-block">{{ $message }}</span>@enderror
    </div>
    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
        <label>{{ __('Confirm Password') }}</label>
        <input type="password" name="password_confirmation" class="form-control" required>
        @error('password_confirmation')<span class="help-block">{{ $message }}</span>@enderror
    </div>
    <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
</form>
@endsection
