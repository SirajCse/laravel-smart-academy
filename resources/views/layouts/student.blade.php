<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($isRtl ?? false) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $schoolName ?? config('app.name'))</title>

    <link rel="stylesheet" href="{{ asset('backend/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/skins/skin-blue.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables/dataTables.bootstrap.css') }}">

    @stack('styles')
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <a href="{{ route('student.dashboard') }}" class="logo">
            <span class="logo-mini"><b>S</b>A</span>
            <span class="logo-lg">{{ $schoolName ?? config('app.name') }}</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ $studentImage ? asset('storage/'.$studentImage) : asset('backend/dist/img/avatar.png') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ $studentName }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-footer">
                                <div class="pull-right">
                                    <form method="POST" action="{{ route('student.logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-default btn-flat">{{ __('Sign out') }}</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="{{ isActiveMenu('student.dashboard') }}"><a href="{{ route('student.dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ __('Dashboard') }}</span></a></li>
                <li class="{{ isActiveMenu('student.profile.*') }}"><a href="{{ route('student.profile') }}"><i class="fa fa-user"></i> <span>{{ __('My Profile') }}</span></a></li>
                <li class="{{ isActiveMenu('student.fees.*') }}"><a href="{{ route('student.fees.index') }}"><i class="fa fa-money"></i> <span>{{ __('Fees') }}</span></a></li>
                <li class="{{ isActiveMenu('student.attendance.*') }}"><a href="{{ route('student.attendance.index') }}"><i class="fa fa-calendar-check-o"></i> <span>{{ __('Attendance') }}</span></a></li>
                <li class="{{ isActiveMenu('student.homework.*') }}"><a href="{{ route('student.homework.index') }}"><i class="fa fa-book"></i> <span>{{ __('Homework') }}</span></a></li>
                <li class="{{ isActiveMenu('student.exam.*') }}"><a href="{{ route('student.exam.index') }}"><i class="fa fa-graduation-cap"></i> <span>{{ __('Exams') }}</span></a></li>
                <li class="{{ isActiveMenu('student.apply-leave.*') }}"><a href="{{ route('student.apply-leave.index') }}"><i class="fa fa-file-text-o"></i> <span>{{ __('Apply Leave') }}</span></a></li>
                <li class="{{ isActiveMenu('student.book.*') }}"><a href="{{ route('student.book.index') }}"><i class="fa fa-book"></i> <span>{{ __('Library') }}</span></a></li>
                <li class="{{ isActiveMenu('student.notification.*') }}"><a href="{{ route('student.notification.index') }}"><i class="fa fa-bell-o"></i> <span>{{ __('Notifications') }}</span></a></li>
                <li class="{{ isActiveMenu('student.chat.*') }}"><a href="{{ route('student.chat.index') }}"><i class="fa fa-comments"></i> <span>{{ __('Chat') }}</span></a></li>
                <li class="{{ isActiveMenu('student.timetable.*') }}"><a href="{{ route('student.timetable.index') }}"><i class="fa fa-clock-o"></i> <span>{{ __('Timetable') }}</span></a></li>
                <li class="{{ isActiveMenu('student.change_password.*') }}"><a href="{{ route('student.change_password.index') }}"><i class="fa fa-key"></i> <span>{{ __('Change Password') }}</span></a></li>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header"><h1>@yield('title')</h1></section>
        <section class="content">
            @if(session('success'))<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ session('error') }}</div>@endif
            @yield('content')
        </section>
    </div>
</div>

<script src="{{ asset('backend/plugins/jQuery/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('backend/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/app.min.js') }}"></script>
<script src="{{ asset('backend/js/custom.js') }}"></script>
@stack('scripts')
</body>
</html>
