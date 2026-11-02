@extends('layouts.admin')

@section('title', __('Classes'))
@section('content_header', __('Manage Classes'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Classes List') }</h3>
        <div class="box-tools">
            @can('admin.class.create')
                <a href="{{ route('admin.class.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> { __('Add New') }</a>
            @endcan
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>{ __('Class Name') }</th>
                    <th>{ __('Note') }</th>
                    <th>{ __('Status') }</th>
                    <th>{ __('Actions') }</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->class }}</td>
                    <td>{{ $record->note }}</td>
                    <td>{{ $record->is_active }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.class.show', $record) }}" class="btn btn-xs btn-info" title="{ __('View') }"><i class="fa fa-eye"></i></a>
                            @can('admin.class.edit')
                                <a href="{{ route('admin.class.edit', $record) }}" class="btn btn-xs btn-warning" title="{ __('Edit') }"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('admin.class.delete')
                                <form method="POST" action="{{ route('admin.class.destroy', $record) }}" style="display:inline-block;" onsubmit="return confirm('{ __('Are you sure?') }')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="{ __('Delete') }"><i class="fa fa-trash"></i></button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">{ __('No records found') }</td></tr>
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
