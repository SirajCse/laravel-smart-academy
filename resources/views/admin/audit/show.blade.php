@extends('layouts.admin')

@section('title', __('Audit Logs Detail'))
@section('content_header', __('Audit Logs Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Audit Logs Details') }</h3>
        <div class="box-tools">
            @can('admin.audit.edit')
                <a href="{{ route('admin.audit.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.audit.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Module') }</th><td>{{ $record->module }}</td></tr>
                <tr><th width="30%">{ __('Action') }</th><td>{{ $record->action }}</td></tr>
                <tr><th width="30%">{ __('Message') }</th><td>{{ $record->message }}</td></tr>
        </table>
    </div>
</div>
@endsection
