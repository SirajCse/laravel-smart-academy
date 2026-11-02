@extends('layouts.admin')

@section('title', __('Holidays Detail'))
@section('content_header', __('Holidays Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Holidays Details') }</h3>
        <div class="box-tools">
            @can('admin.holiday.edit')
                <a href="{{ route('admin.holiday.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.holiday.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Title') }</th><td>{{ $record->title }}</td></tr>
                <tr><th width="30%">{ __('From Date') }</th><td>{{ $record->from_date }}</td></tr>
                <tr><th width="30%">{ __('To Date') }</th><td>{{ $record->to_date }}</td></tr>
                <tr><th width="30%">{ __('Description') }</th><td>{{ $record->description }}</td></tr>
        </table>
    </div>
</div>
@endsection
