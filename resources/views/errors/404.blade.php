@extends('layouts.auth')

@section('title', __('Page Not Found'))

@section('content')
<div class="error-page">
    <h2 class="headline text-yellow">404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> {{ __('Oops! Page not found.') }}</h3>
        <p>{{ __('We could not find the page you were looking for.') }}</p>
        <p>{{ __('Meanwhile, you may') }} <a href="{{ route('admin.dashboard') }}">{{ __('return to dashboard') }}</a>.</p>
    </div>
</div>
@endsection
