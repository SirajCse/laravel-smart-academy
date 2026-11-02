@extends('layouts.admin')

@section('title', __('Staff'))
@section('content_header', __('Manage Staff'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Staff List') }</h3>
        <div class="box-tools">
            @can('admin.staff.create')
                <a href="{{ route('admin.staff.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> { __('Add New') }</a>
            @endcan
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>{ __('Name') }</th>
                    <th>{ __('Email') }</th>
                    <th>{ __('Phone') }</th>
                    <th>{ __('Gender') }</th>
                    <th>{ __('Date of Birth') }</th>
                    <th>{ __('Joining Date') }</th>
                    <th>{ __('Photo') }</th>
                    <th>{ __('Actions') }</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->email }}</td>
                    <td>{{ $record->phone }}</td>
                    <td>{{ $record->gender }}</td>
                    <td>{{ $record->dob }}</td>
                    <td>{{ $record->joining_date }}</td>
                    <td>{{ $record->image }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.staff.show', $record) }}" class="btn btn-xs btn-info" title="{ __('View') }"><i class="fa fa-eye"></i></a>
                            @can('admin.staff.edit')
                                <a href="{{ route('admin.staff.edit', $record) }}" class="btn btn-xs btn-warning" title="{ __('Edit') }"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('admin.staff.delete')
                                <form method="POST" action="{{ route('admin.staff.destroy', $record) }}" style="display:inline-block;" onsubmit="return confirm('{ __('Are you sure?') }')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="{ __('Delete') }"><i class="fa fa-trash"></i></button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">{ __('No records found') }</td></tr>
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
