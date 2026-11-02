@extends('layouts.admin')

@section('title', __('Class Section Detail'))
@section('content_header', __('Class Section Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Class Section Details') }</h3>
        <div class="box-tools">
            @can('admin.class-section.edit')
                <a href="{{ route('admin.class-section.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.class-section.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            @foreach($record->toArray() as $key => $value)
                <tr>
                    <th width="30%">{ ucfirst(str_replace('_', ' ', $key)) }</th>
                    <td>{ is_array($value) ? json_encode($value) : $value }</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
