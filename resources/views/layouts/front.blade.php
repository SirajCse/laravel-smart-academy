<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($isRtl ?? false) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $schoolName ?? config('app.name'))</title>

    <link rel="stylesheet" href="{{ asset('backend/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/font-awesome.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('themes/'.$theme.'/css/style.css') }}">

    @stack('styles')
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ $schoolLogo ?? '' }}" alt="{{ $schoolName ?? '' }}" height="40">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right">
                @foreach($menus ?? [] as $menu)
                    <li class="{{ isActiveMenu('page.read') }}">
                        <a href="{{ $menu->page_id ? route('page.read', $menu->slug) : $menu->url }}" @if($menu->open_in_new_tab) target="_blank" @endif>{{ $menu->title }}</a>
                    </li>
                @endforeach
                <li><a href="{{ route('admin.login') }}" class="btn btn-success btn-login">{{ __('Staff Login') }}</a></li>
                <li><a href="{{ route('student.login') }}" class="btn btn-info btn-login">{{ __('Student Login') }}</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container content-wrapper">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @yield('content')
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4"><p>&copy; {{ date('Y') }} {{ $schoolName ?? config('app.name') }}</p></div>
            <div class="col-md-4"><p>{{ $officeHours ?? '' }}</p></div>
            <div class="col-md-4 social-links">
                @if(!empty($facebookUrl))<a href="{{ $facebookUrl }}"><i class="fa fa-facebook"></i></a>@endif
                @if(!empty($twitterUrl))<a href="{{ $twitterUrl }}"><i class="fa fa-twitter"></i></a>@endif
                @if(!empty($linkedinUrl))<a href="{{ $linkedinUrl }}"><i class="fa fa-linkedin"></i></a>@endif
                @if(!empty($instagramUrl))<a href="{{ $instagramUrl }}"><i class="fa fa-instagram"></i></a>@endif
                @if(!empty($youtubeUrl))<a href="{{ $youtubeUrl }}"><i class="fa fa-youtube"></i></a>@endif
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('backend/plugins/jQuery/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('backend/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('themes/'.$theme.'/js/script.js') }}"></script>
@stack('scripts')
</body>
</html>
