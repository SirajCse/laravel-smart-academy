@extends('layouts.student')

@section('title', __('Fees'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Fee Summary') }}</h3></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-3"><div class="small-box bg-aqua"><div class="inner"><h3>{{ formatCurrency($total ?? 0) }}</h3><p>{{ __('Total') }}</p></div></div></div>
            <div class="col-md-3"><div class="small-box bg-green"><div class="inner"><h3>{{ formatCurrency($paid ?? 0) }}</h3><p>{{ __('Paid') }}</p></div></div></div>
            <div class="col-md-3"><div class="small-box bg-red"><div class="inner"><h3>{{ formatCurrency($due ?? 0) }}</h3><p>{{ __('Due') }}</p></div></div></div>
            <div class="col-md-3"><div class="small-box bg-yellow"><div class="inner"><h3>{{ formatCurrency($discount ?? 0) }}</h3><p>{{ __('Discount') }}</p></div></div></div>
        </div>
        <hr>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Fee Type') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Discount') }}</th>
                    <th>{{ __('Paid') }}</th>
                    <th>{{ __('Balance') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fees ?? [] as $i => $fee)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $fee->feeSessionGroup?->groupType?->type?->name ?? '-' }}</td>
                    <td>{{ formatCurrency($fee->amount) }}</td>
                    <td>{{ formatCurrency($fee->discount_amount) }}</td>
                    <td>{{ formatCurrency($fee->payments->sum('amount')) }}</td>
                    <td>{{ formatCurrency($fee->amount - $fee->discount_amount - $fee->payments->sum('amount')) }}</td>
                    <td>
                        @if($fee->amount - $fee->discount_amount - $fee->payments->sum('amount') > 0)
                            <a href="{{ route('student.fees.show', $fee) }}" class="btn btn-success btn-xs"><i class="fa fa-credit-card"></i> {{ __('Pay Now') }}</a>
                        @else
                            <span class="label label-success">{{ __('Paid') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">{{ __('No fees found') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
