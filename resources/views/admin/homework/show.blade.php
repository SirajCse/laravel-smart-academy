@extends('layouts.admin')

@section('title', __('Homework'))
@section('content_header', __('Homework Show'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Homework') }}</h3></div>
    <div class="box-body">
        <table class="table table-bordered">
            @foreach($record->toArray() as $key => $value)
                <tr><th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th><td>{{ is_array($value) ? json_encode($value) : $value }}</td></tr>
            @endforeach
        </table>
        <a href="{{ route('admin.homework.index') }}" class="btn btn-default">{{ __('Back to List') }}</a>
    </div>
</div>
@endsection
