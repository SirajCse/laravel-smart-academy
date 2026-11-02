@extends('layouts.admin')

@section('title', __('Currencies Detail'))
@section('content_header', __('Currencies Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Currencies Details') }</h3>
        <div class="box-tools">
            @can('admin.currency.edit')
                <a href="{{ route('admin.currency.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.currency.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Currency') }</th><td>{{ $record->currency }}</td></tr>
                <tr><th width="30%">{ __('Symbol') }</th><td>{{ $record->symbol }}</td></tr>
                <tr><th width="30%">{ __('Placement') }</th><td>{{ $record->placement }}</td></tr>
        </table>
    </div>
</div>
@endsection
