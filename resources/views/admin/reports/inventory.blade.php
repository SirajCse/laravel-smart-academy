@extends('layouts.admin')

@section('title', __('Inventory Report'))
@section('content_header', __('Inventory Report'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{ __('Inventory Report') }</h3></div>
    <div class="box-body">
        <table class="table table-hover table-striped datatable">
            <thead>
                <tr><th>#</th><th>{ __('Reference') }</th><th>{ __('Date') }</th><th>{ __('Amount/Status') }</th></tr>
            </thead>
            <tbody>
                @forelse($records as $i => $record)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $record->name ?? $record->title ?? $record->id }}</td>
                    <td>{{ formatDate($record->created_at ?? $record->date ?? now()) }}</td>
                    <td>{{ $record->amount ? formatCurrency($record->amount) : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">{ __('No records found') }</td></tr>
                @endforelse
            </tbody>
        </table>
        @if(isset($records) && $records instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $records->withQueryString()->links() }}
        @endif
    </div>
</div>
@endsection
@push('scripts')
<script>$(document).ready(function() { $('.datatable').DataTable({ pageLength: 25 }); });</script>
@endpush
