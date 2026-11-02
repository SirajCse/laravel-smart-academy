@extends('layouts.admin')

@section('title', __('Classes Detail'))
@section('content_header', __('Classes Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Classes Details') }</h3>
        <div class="box-tools">
            @can('admin.class.edit')
                <a href="{{ route('admin.class.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.class.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Class Name') }</th><td>{{ $record->class }}</td></tr>
                <tr><th width="30%">{ __('Note') }</th><td>{{ $record->note }}</td></tr>
                <tr><th width="30%">{ __('Status') }</th><td>{{ $record->is_active }}</td></tr>
        </table>
    </div>
</div>
@endsection
