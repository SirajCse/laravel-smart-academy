@extends('layouts.admin')

@section('title', __('Enquiries Detail'))
@section('content_header', __('Enquiries Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Enquiries Details') }</h3>
        <div class="box-tools">
            @can('admin.enquiry.edit')
                <a href="{{ route('admin.enquiry.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.enquiry.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Name') }</th><td>{{ $record->name }}</td></tr>
                <tr><th width="30%">{ __('Email') }</th><td>{{ $record->email }}</td></tr>
                <tr><th width="30%">{ __('Phone') }</th><td>{{ $record->phone }}</td></tr>
                <tr><th width="30%">{ __('Purpose') }</th><td>{{ $record->purpose }}</td></tr>
                <tr><th width="30%">{ __('Date') }</th><td>{{ $record->date }}</td></tr>
                <tr><th width="30%">{ __('Status') }</th><td>{{ $record->status }}</td></tr>
        </table>
    </div>
</div>
@endsection
