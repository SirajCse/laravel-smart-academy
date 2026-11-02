@extends('layouts.admin')

@section('title', __('Fee Types Detail'))
@section('content_header', __('Fee Types Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Fee Types Details') }</h3>
        <div class="box-tools">
            @can('admin.feetype.edit')
                <a href="{{ route('admin.feetype.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.feetype.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Code') }</th><td>{{ $record->code }}</td></tr>
                <tr><th width="30%">{ __('Name') }</th><td>{{ $record->name }}</td></tr>
                <tr><th width="30%">{ __('Description') }</th><td>{{ $record->description }}</td></tr>
        </table>
    </div>
</div>
@endsection
