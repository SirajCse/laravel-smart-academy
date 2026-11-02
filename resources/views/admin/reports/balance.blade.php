@extends('layouts.admin')

@section('title', __('Balance Report'))
@section('content_header', __('Balance Report'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Balance Summary') }}</h3></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-green">
                    <div class="inner"><h3>{{ formatCurrency($income) }}</h3><p>{{ __('Total Income') }}</p></div>
                    <div class="icon"><i class="fa fa-plus-circle"></i></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-red">
                    <div class="inner"><h3>{{ formatCurrency($expense) }}</h3><p>{{ __('Total Expense') }}</p></div>
                    <div class="icon"><i class="fa fa-minus-circle"></i></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-aqua">
                    <div class="inner"><h3>{{ formatCurrency($balance) }}</h3><p>{{ __('Balance') }}</p></div>
                    <div class="icon"><i class="fa fa-balance-scale"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
