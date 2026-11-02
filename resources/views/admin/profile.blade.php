@extends('layouts.admin')

@section('title', __('My Profile'))
@section('content_header', __('My Profile'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Profile Information') }}</h3></div>
    <div class="box-body">
        <table class="table table-bordered">
            <tr><th>{{ __('Name') }}</th><td>{{ $staff->name }}</td></tr>
            <tr><th>{{ __('Email') }}</th><td>{{ $staff->email }}</td></tr>
            <tr><th>{{ __('Phone') }}</th><td>{{ $staff->phone }}</td></tr>
            <tr><th>{{ __('Role') }}</th><td>{{ $staff->roles?->first()?->name ?? '-' }}</td></tr>
            <tr><th>{{ __('Department') }}</th><td>{{ $staff->department?->department_name ?? '-' }}</td></tr>
            <tr><th>{{ __('Designation') }}</th><td>{{ $staff->designation?->designation ?? '-' }}</td></tr>
            <tr><th>{{ __('Joining Date') }}</th><td>{{ formatDate($staff->joining_date) }}</td></tr>
            <tr><th>{{ __('Status') }}</th><td>{{ $staff->is_active ? 'Active' : 'Inactive' }}</td></tr>
        </table>
        <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-warning"><i class="fa fa-edit"></i> {{ __('Edit Profile') }}</a>
    </div>
</div>
@endsection
