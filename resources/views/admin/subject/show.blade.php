@extends('layouts.admin')

@section('title', __('Subjects Detail'))
@section('content_header', __('Subjects Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Subjects Details') }</h3>
        <div class="box-tools">
            @can('admin.subject.edit')
                <a href="{{ route('admin.subject.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.subject.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Subject Name') }</th><td>{{ $record->name }}</td></tr>
                <tr><th width="30%">{ __('Code') }</th><td>{{ $record->code }}</td></tr>
                <tr><th width="30%">{ __('Type') }</th><td>{{ $record->type }}</td></tr>
        </table>
    </div>
</div>
@endsection
