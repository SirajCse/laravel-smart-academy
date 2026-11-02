@extends('layouts.admin')

@section('title', __('Generate Staffidcard Detail'))
@section('content_header', __('Generate Staffidcard Detail'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Generate Staffidcard Details') }</h3>
        <div class="box-tools">
            @can('admin.generate-staffidcard.edit')
                <a href="{{ route('admin.generate-staffidcard.edit', $record) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> { __('Edit') }</a>
            @endcan
            <a href="{{ route('admin.generate-staffidcard.index') }}" class="btn btn-default btn-sm"><i class="fa fa-list"></i> { __('List') }</a>
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
