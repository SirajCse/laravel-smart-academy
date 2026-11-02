@extends('layouts.admin')

@section('title', __('Designations Detail'))
@section('content_header', __('Designations Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Designations Details') }</h3>
        <div class="box-tools">
            @can('admin.designation.edit')
                <a href="{{ route('admin.designation.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.designation.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Designation') }</th><td>{{ $record->designation }}</td></tr>
                <tr><th width="30%">{ __('Description') }</th><td>{{ $record->description }}</td></tr>
        </table>
    </div>
</div>
@endsection
