@extends('layouts.admin')

@section('title', __('Income'))
@section('content_header', __('Manage Income'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Income List') }</h3>
        <div class="box-tools">
            @can('admin.income.create')
                <a href="{{ route('admin.income.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> { __('Add New') }</a>
            @endcan
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>{ __('Title') }</th>
                    <th>{ __('Invoice No') }</th>
                    <th>{ __('Amount') }</th>
                    <th>{ __('Date') }</th>
                    <th>{ __('Actions') }</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->invoice_no }}</td>
                    <td>{{ $record->amount }}</td>
                    <td>{{ $record->date }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.income.show', $record) }}" class="btn btn-xs btn-info" title="{ __('View') }"><i class="fa fa-eye"></i></a>
                            @can('admin.income.edit')
                                <a href="{{ route('admin.income.edit', $record) }}" class="btn btn-xs btn-warning" title="{ __('Edit') }"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('admin.income.delete')
                                <form method="POST" action="{{ route('admin.income.destroy', $record) }}" style="display:inline-block;" onsubmit="return confirm('{ __('Are you sure?') }')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="{ __('Delete') }"><i class="fa fa-trash"></i></button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">{ __('No records found') }</td></tr>
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
