@extends('layouts.admin')

@section('title', __('Fee Categories Detail'))
@section('content_header', __('Fee Categories Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Fee Categories Details') }</h3>
        <div class="box-tools">
            @can('admin.feecategory.edit')
                <a href="{{ route('admin.feecategory.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.feecategory.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Name') }</th><td>{{ $record->name }}</td></tr>
        </table>
    </div>
</div>
@endsection
