@extends('layouts.admin')

@section('title', __('Students'))
@section('content_header', __('Manage Students'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('Students List') }}</h3>
        <div class="box-tools">
            @can('student.create')
                <a href="{{ route('admin.student.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ __('Add Student') }}</a>
            @endcan
            <a href="{{ route('admin.student.import.sample') }}" class="btn btn-info btn-sm"><i class="fa fa-download"></i> {{ __('Sample CSV') }}</a>
        </div>
    </div>
    <div class="box-body">
        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.student.index') }}" class="form-inline" id="filter-form">
            <div class="form-group">
                <label for="class_filter">{{ __('Class') }}:</label>
                <select name="class_id" id="class_filter" class="form-control select2" onchange="updateSections(this.value)">
                    <option value="">{{ __('All') }}</option>
                    @foreach(getClasses() as $id => $name)
                        <option value="{{ $id }}" @if(request('class_id') == $id) selected @endif>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="section_filter">{{ __('Section') }}:</label>
                <select name="section_id" id="section_filter" class="form-control select2">
                    <option value="">{{ __('All') }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="search">{{ __('Search') }}:</label>
                <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('Admission No, Name, Phone') }}">
            </div>
            <button type="submit" class="btn btn-default"><i class="fa fa-filter"></i> {{ __('Filter') }}</button>
            <a href="{{ route('admin.student.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i> {{ __('Reset') }}</a>
        </form>

        <hr>

        <table class="table table-hover table-striped datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Admission No') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Class') }}</th>
                    <th>{{ __('Section') }}</th>
                    <th>{{ __('Father') }}</th>
                    <th>{{ __('Mobile') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $i => $student)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $student->admission_no }}</td>
                    <td><a href="{{ route('admin.student.show', $student) }}">{{ $student->firstname }} {{ $student->middlename }} {{ $student->lastname }}</a></td>
                    <td>{{ $student->currentSession?->class?->class ?? '-' }}</td>
                    <td>{{ $student->currentSession?->section?->section ?? '-' }}</td>
                    <td>{{ $student->father_name }}</td>
                    <td>{{ $student->mobileno }}</td>
                    <td>
                        @if($student->is_active)
                            <span class="label label-success">{{ __('Active') }}</span>
                        @else
                            <span class="label label-danger">{{ __('Disabled') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.student.show', $student) }}" class="btn btn-xs btn-info" title="{{ __('View') }}"><i class="fa fa-eye"></i></a>
                            @can('student.edit')
                                <a href="{{ route('admin.student.edit', $student) }}" class="btn btn-xs btn-warning" title="{{ __('Edit') }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('student.delete')
                                <form method="POST" action="{{ route('admin.student.destroy', $student) }}" style="display:inline-block;" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="{{ __('Delete') }}"><i class="fa fa-trash"></i></button>
                                </form>
                            @endcan
                            @can('student_fees.view')
                                <a href="{{ route('admin.student.fees', $student) }}" class="btn btn-xs btn-success" title="{{ __('Fees') }}"><i class="fa fa-money"></i></a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted">{{ __('No students found') }}</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $students->withQueryString()->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateSections(classId) {
    $.get('{{ route('admin.class.sectionsByClass', 0) }}'.replace('/0', '/' + classId), function(data) {
        var $select = $('#section_filter');
        $select.empty().append('<option value="">{{ __('All') }}</option>');
        Object.entries(data).forEach(function([id, name]) {
            $select.append('<option value="' + id + '">' + name + '</option>');
        });
    });
}
$(document).ready(function() {
    $('.datatable').DataTable({ pageLength: 25 });
});
</script>
@endpush
