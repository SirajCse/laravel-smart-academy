@extends('layouts.admin')

@section('title', __('Sections Detail'))
@section('content_header', __('Sections Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Sections Details') }</h3>
        <div class="box-tools">
            @can('admin.section.edit')
                <a href="{{ route('admin.section.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.section.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Section Name') }</th><td>{{ $record->section }}</td></tr>
                <tr><th width="30%">{ __('Note') }</th><td>{{ $record->note }}</td></tr>
        </table>
    </div>
</div>
@endsection
