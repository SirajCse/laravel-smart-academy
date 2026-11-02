@extends('layouts.admin')
@section('title', __('Student Fees'))
@section('content_header', __('Student Fees'))
@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Fees Records') }}</h3></div>
    <div class="box-body">
        <table class="table table-hover table-striped datatable">
            <thead>
                <tr><th>#</th><th>{{ __('Student') }}</th><th>{{ __('Fee Type') }}</th><th>{{ __('Amount') }}</th><th>{{ __('Paid') }}</th><th>{{ __('Discount') }}</th><th>{{ __('Actions') }}</th></tr>
            </thead>
            <tbody>
                @forelse($records as $i => $record)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $record->studentSession?->student?->firstname ?? '-' }}</td>
                    <td>{{ $record->feeSessionGroup?->groupType?->type?->name ?? '-' }}</td>
                    <td>{{ formatCurrency($record->amount) }}</td>
                    <td>{{ formatCurrency($record->payments->sum('amount')) }}</td>
                    <td>{{ formatCurrency($record->discount_amount) }}</td>
                    <td>
                        <a href="{{ route('admin.student-fee.show', $record) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">{{ __('No fee records found') }}</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $records->withQueryString()->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script>$(document).ready(function() { $('.datatable').DataTable({ pageLength: 25 }); });</script>
@endpush
