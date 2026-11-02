@extends('layouts.admin')

@section('title', __('Books Detail'))
@section('content_header', __('Books Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Books Details') }</h3>
        <div class="box-tools">
            @can('admin.book.edit')
                <a href="{{ route('admin.book.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.book.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
                <tr><th width="30%">{ __('Title') }</th><td>{{ $record->book_title }}</td></tr>
                <tr><th width="30%">{ __('Book No') }</th><td>{{ $record->book_no }}</td></tr>
                <tr><th width="30%">{ __('Author') }</th><td>{{ $record->author }}</td></tr>
                <tr><th width="30%">{ __('Quantity') }</th><td>{{ $record->qty }}</td></tr>
        </table>
    </div>
</div>
@endsection
