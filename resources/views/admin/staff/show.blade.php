@extends('layouts.admin')

@section('title', __('Staff Detail'))
@section('content_header', __('Staff Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Staff Details') }</h3>
        <div class="box-tools">
            @can('admin.staff.edit')
                <a href="{{ route('admin.staff.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.staff.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Name') }</th><td>{{ $record->name }}</td></tr>
                <tr><th width="30%">{ __('Email') }</th><td>{{ $record->email }}</td></tr>
                <tr><th width="30%">{ __('Phone') }</th><td>{{ $record->phone }}</td></tr>
                <tr><th width="30%">{ __('Gender') }</th><td>{{ $record->gender }}</td></tr>
                <tr><th width="30%">{ __('Date of Birth') }</th><td>{{ $record->dob }}</td></tr>
                <tr><th width="30%">{ __('Joining Date') }</th><td>{{ $record->joining_date }}</td></tr>
                <tr><th width="30%">{ __('Photo') }</th><td>{{ $record->image }}</td></tr>
        </table>
    </div>
</div>
@endsection
