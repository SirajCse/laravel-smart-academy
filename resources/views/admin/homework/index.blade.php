@extends('layouts.admin')

@section('title', __('Homework'))
@section('content_header', __('Manage Homework'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('Homework List') }}</h3>
        <div class="box-tools">
            @can('homework.create')
                <a href="{{ route('admin.homework.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ __('Add Homework') }}</a>
            @endcan
        </div>
    </div>
    <div class="box-body">
        <table class="table table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Class') }}</th>
                    <th>{{ __('Section') }}</th>
                    <th>{{ __('Subject') }}</th>
                    <th>{{ __('Staff') }}</th>
                    <th>{{ __('Homework Date') }}</th>
                    <th>{{ __('Submit Date') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $record)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $record->class?->class ?? '-' }}</td>
                    <td>{{ $record->section?->section ?? '-' }}</td>
                    <td>{{ $record->subject?->name ?? '-' }}</td>
                    <td>{{ $record->staff?->name ?? '-' }}</td>
                    <td>{{ formatDate($record->homework_date) }}</td>
                    <td>{{ formatDate($record->submit_date) }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.homework.show', $record) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                            @can('homework.edit')
                                <a href="{{ route('admin.homework.edit', $record) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('homework.delete')
                                <form method="POST" action="{{ route('admin.homework.destroy', $record) }}" style="display:inline-block;" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">{{ __('No homework found') }}</td></tr>
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
