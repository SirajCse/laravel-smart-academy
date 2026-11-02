@extends('layouts.admin')

@section('title', __('Income Detail'))
@section('content_header', __('Income Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Income Details') }</h3>
        <div class="box-tools">
            @can('admin.income.edit')
                <a href="{{ route('admin.income.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.income.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Title') }</th><td>{{ $record->name }}</td></tr>
                <tr><th width="30%">{ __('Invoice No') }</th><td>{{ $record->invoice_no }}</td></tr>
                <tr><th width="30%">{ __('Amount') }</th><td>{{ $record->amount }}</td></tr>
                <tr><th width="30%">{ __('Date') }</th><td>{{ $record->date }}</td></tr>
        </table>
    </div>
</div>
@endsection
