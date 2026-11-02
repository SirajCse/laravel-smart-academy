@extends('layouts.admin')

@section('title', __('Holidays'))
@section('content_header', __('Manage Holidays'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Holidays List') }</h3>
        <div class="box-tools">
            @can('admin.holiday.create')
                <a href="{{ route('admin.holiday.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> { __('Add New') }</a>
            @endcan
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>{ __('Title') }</th>
                    <th>{ __('From Date') }</th>
                    <th>{ __('To Date') }</th>
                    <th>{ __('Description') }</th>
                    <th>{ __('Actions') }</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->title }}</td>
                    <td>{{ $record->from_date }}</td>
                    <td>{{ $record->to_date }}</td>
                    <td>{{ $record->description }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.holiday.show', $record) }}" class="btn btn-xs btn-info" title="{ __('View') }"><i class="fa fa-eye"></i></a>
                            @can('admin.holiday.edit')
                                <a href="{{ route('admin.holiday.edit', $record) }}" class="btn btn-xs btn-warning" title="{ __('Edit') }"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('admin.holiday.delete')
                                <form method="POST" action="{{ route('admin.holiday.destroy', $record) }}" style="display:inline-block;" onsubmit="return confirm('{ __('Are you sure?') }')">
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
