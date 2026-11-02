@extends('layouts.admin')

@section('title', __('Homework Evaluation'))
@section('content_header', __('Manage Homework Evaluation'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{ __('Homework Evaluation List') }</h3>
        <div class="box-tools">
            @can('admin.homework-evaluation.create')
                <a href="{{ route('admin.homework-evaluation.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> { __('Add New') }</a>
            @endcan
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{ __('Name') }</th>
                    <th>{ __('Created') }</th>
                    <th>{ __('Actions') }</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $record)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $record->name ?? $record->title ?? $record->id }}</td>
                    <td>{{ formatDate($record->created_at) }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.homework-evaluation.show', $record) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                            @can('admin.homework-evaluation.edit')
                                <a href="{{ route('admin.homework-evaluation.edit', $record) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('admin.homework-evaluation.delete')
                                <form method="POST" action="{{ route('admin.homework-evaluation.destroy', $record) }}" style="display:inline-block;" onsubmit="return confirm('{ __('Are you sure?') }')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
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
        @if($records instanceof \Illuminate\Pagination\LengthAwarePaginator)
            { $records->withQueryString()->links() }
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>$(document).ready(function() { $('.datatable').DataTable({ pageLength: 25 }); });</script>
@endpush
