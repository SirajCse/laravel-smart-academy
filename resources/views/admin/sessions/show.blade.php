@extends('layouts.admin')

@section('title', __('Sessions Detail'))
@section('content_header', __('Sessions Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Sessions Details') }</h3>
        <div class="box-tools">
            @can('admin.session.edit')
                <a href="{{ route('admin.session.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.session.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Session Year') }</th><td>{{ $record->session }}</td></tr>
                <tr><th width="30%">{ __('Active') }</th><td>{{ $record->is_active }}</td></tr>
        </table>
    </div>
</div>
@endsection
