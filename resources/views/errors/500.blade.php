@extends('layouts.auth')

@section('title', __('Server Error'))

@section('content')
<div class="error-page">
    <h2 class="headline text-red">500</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-red"></i> {{ __('Oops! Something went wrong.') }}</h3>
        <p>{{ __('We will work on fixing that right away.') }}</p>
        <p>{{ __('Meanwhile, you may') }} <a href="{{ route('admin.dashboard') }}">{{ __('return to dashboard') }}</a>.</p>
    </div>
</div>
@endsection
