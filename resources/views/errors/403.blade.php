@extends('layouts.auth')

@section('title', __('Unauthorized'))

@section('content')
<div class="alert alert-danger">
    <h3><i class="fa fa-warning"></i> {{ __('Access Denied') }}</h3>
    <p>{{ __('You do not have permission to access this page.') }}</p>
    <p>{{ __('If you believe this is an error, please contact the system administrator.') }}</p>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-default">{{ __('Go to Dashboard') }}</a>
</div>
@endsection
