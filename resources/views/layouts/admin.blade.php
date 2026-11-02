<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($isRtl ?? false) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $schoolName ?? config('app.name'))</title>

    {{-- AdminLTE 2.x assets (kept from CI3) --}}
    <link rel="stylesheet" href="{{ asset('backend/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/skins/skin-blue.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/timepicker/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/toast-alert/toast.min.css') }}">

    @stack('styles')
</head>
<body class="hold-transition skin-blue fixed sidebar-mini @if($isRtl ?? false) sidebar-collapse @endif">
<div class="wrapper">

    {{-- Header --}}
    <header class="main-header">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <span class="logo-mini"><b>S</b>A</span>
            <span class="logo-lg">{{ $schoolName ?? config('app.name') }}</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ $staffImage ? asset('storage/'.$staffImage) : asset('backend/dist/img/avatar.png') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ $staffName }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ $staffImage ? asset('storage/'.$staffImage) : asset('backend/dist/img/avatar.png') }}" class="img-circle" alt="User Image">
                                <p>{{ $staffName }} - {{ $staffRole }}<small>Member since {{ formatDate($currentStaff->created_at ?? now()) }}</small></p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">{{ __('Profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <form method="POST" action="{{ route('admin.logout') }}">
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

    {{-- Sidebar --}}
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ $staffImage ? asset('storage/'.$staffImage) : asset('backend/dist/img/avatar.png') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ $staffName }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ $staffRole }}</a>
                </div>
            </div>

            <ul class="sidebar-menu" data-widget="tree">
                @foreach($menu as $item)
                    @php
                        $routeName = 'admin.' . $item->short_code . '.index';
                        $altRouteName = 'admin.' . $item->short_code;
                        $routeExists = \Illuminate\Support\Facades\Route::has($routeName) || \Illuminate\Support\Facades\Route::has($altRouteName);
                        $href = $routeExists
                            ? route(\Illuminate\Support\Facades\Route::has($routeName) ? $routeName : $altRouteName)
                            : '#';
                    @endphp
                    @if($item->children->isEmpty())
                        <li class="{{ isActiveMenu('admin.'.$item->short_code.'.*') }}">
                            <a href="{{ $href }}">
                                <i class="fa {{ $item->icon ?? 'fa-circle-o' }}"></i>
                                <span>{{ __($item->name) }}</span>
                            </a>
                        </li>
                    @else
                        <li class="treeview {{ isActiveMenu('admin.'.$item->short_code.'.*') }}">
                            <a href="#"><i class="fa {{ $item->icon ?? 'fa-folder' }}"></i> <span>{{ __($item->name) }}</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                            <ul class="treeview-menu">
                                @foreach($item->children as $child)
                                    @can($child->short_code . '.view')
                                        <li class="{{ isActiveMenu('admin.'.$child->short_code.'.*') }}">
                                            <a href="{{ route('admin.'.$child->short_code.'.index') }}"><i class="fa fa-circle-o"></i> {{ __($child->name) }}</a>
                                        </li>
                                    @endcan
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    </aside>

    {{-- Content --}}
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@yield('content_header', '')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
                @stack('breadcrumbs')
                <li class="active">@yield('title')</li>
            </ol>
        </section>

        <section class="content">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ session('success') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ session('warning') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ session('error') }}</div>
            @endif

            @yield('content')
        </section>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="{{ config('app.url') }}">{{ $schoolName ?? config('app.name') }}</a>.</strong>
        All rights reserved.
    </footer>
</div>

<script src="{{ asset('backend/plugins/jQuery/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('backend/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/app.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('backend/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('backend/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('backend/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('backend/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('backend/plugins/toast-alert/toast.min.js') }}"></script>
<script src="{{ asset('backend/js/custom.js') }}"></script>

@stack('scripts')
</body>
</html>
