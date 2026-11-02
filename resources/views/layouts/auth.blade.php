<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Login')) — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('backend/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/skins/skin-blue.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    @stack('styles')
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img src="{{ $schoolLogo ?? asset('backend/dist/img/logo.png') }}" alt="{{ $schoolName ?? config('app.name') }}" class="img-responsive" style="max-height:80px;">
        <h3>{{ $schoolName ?? config('app.name') }}</h3>
    </div>
    <div class="login-box-body">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @yield('content')
    </div>
</div>
<script src="{{ asset('backend/plugins/jQuery/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('backend/bootstrap/js/bootstrap.min.js') }}"></script>
@stack('scripts')
</body>
</html>
