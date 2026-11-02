@extends('layouts.admin')

@section('title', __('Add Student'))
@section('content_header', __('Add New Student'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Student Information') }}</h3></div>
    <div class="box-body">
        <form method="POST" action="{{ route('admin.student.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Basic Info --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('admission_no') ? 'has-error' : '' }}">
                        <label>{{ __('Admission No') }} <span class="text-red">*</span></label>
                        <input type="text" name="admission_no" class="form-control" value="{{ old('admission_no', generateAdmissionNo()) }}" required>
                        @error('admission_no')<span class="help-block">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Roll No') }}</label>
                        <input type="text" name="roll_no" class="form-control" value="{{ old('roll_no') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Admission Date') }}</label>
                        <input type="date" name="admission_date" class="form-control datepicker" value="{{ old('admission_date', date('Y-m-d')) }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                        <label>{{ __('First Name') }} <span class="text-red">*</span></label>
                        <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}" required>
                        @error('firstname')<span class="help-block">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Middle Name') }}</label>
                        <input type="text" name="middlename" class="form-control" value="{{ old('middlename') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                        <label>{{ __('Last Name') }} <span class="text-red">*</span></label>
                        <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}" required>
                        @error('lastname')<span class="help-block">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Class') }}</label>
                        <select name="class_id" id="class_id" class="form-control select2" onchange="updateSections(this.value)" required>
                            <option value="">{{ __('Select Class') }}</option>
                            @foreach(getClasses() as $id => $name)
                                <option value="{{ $id }}" @if(old('class_id') == $id) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Section') }}</label>
                        <select name="section_id" id="section_id" class="form-control select2">
                            <option value="">{{ __('Select Section') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Category') }}</label>
                        <select name="category_id" class="form-control select2">
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach(\App\Models\Category::pluck('category','id') as $id => $name)
                                <option value="{{ $id }}" @if(old('category_id') == $id) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Date of Birth') }}</label>
                        <input type="date" name="dob" class="form-control datepicker" value="{{ old('dob') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Gender') }}</label>
                        <select name="gender" class="form-control">
                            @foreach(genderList() as $k => $v)
                                <option value="{{ $k }}" @if(old('gender') === $k) selected @endif>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Blood Group') }}</label>
                        <select name="blood_group" class="form-control">
                            <option value="">{{ __('Select') }}</option>
                            @foreach(bloodGroups() as $bg)
                                <option value="{{ $bg }}" @if(old('blood_group') === $bg) selected @endif>{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Mobile') }}</label>
                        <input type="text" name="mobileno" class="form-control" value="{{ old('mobileno') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Photo') }}</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            {{-- Address --}}
            <h4 class="box-title">{{ __('Address Information') }}</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('Current Address') }}</label>
                        <textarea name="current_address" class="form-control" rows="2">{{ old('current_address') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('Permanent Address') }}</label>
                        <textarea name="permanent_address" class="form-control" rows="2">{{ old('permanent_address') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Guardian --}}
            <h4 class="box-title">{{ __('Guardian Information') }}</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Guardian Name') }}</label>
                        <input type="text" name="guardian_name" class="form-control" value="{{ old('guardian_name') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Guardian Phone') }}</label>
                        <input type="text" name="guardian_phone" class="form-control" value="{{ old('guardian_phone') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Guardian Email') }}</label>
                        <input type="email" name="guardian_email" class="form-control" value="{{ old('guardian_email') }}">
                    </div>
                </div>
            </div>

            {{-- Father --}}
            <h4 class="box-title">{{ __('Parent Information') }}</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Father Name') }}</label>
                        <input type="text" name="father_name" class="form-control" value="{{ old('father_name') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Father Phone') }}</label>
                        <input type="text" name="father_phone" class="form-control" value="{{ old('father_phone') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Father Occupation') }}</label>
                        <input type="text" name="father_occupation" class="form-control" value="{{ old('father_occupation') }}">
                    </div>
                </div>
            </div>

            {{-- Mother --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Mother Name') }}</label>
                        <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Mother Phone') }}</label>
                        <input type="text" name="mother_phone" class="form-control" value="{{ old('mother_phone') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Mother Occupation') }}</label>
                        <input type="text" name="mother_occupation" class="form-control" value="{{ old('mother_occupation') }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save Student') }}</button>
                <a href="{{ route('admin.student.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateSections(classId) {
    if (! classId) return;
    $.getJSON('{{ route('admin.class.sectionsByClass', 0) }}'.replace('/0', '/' + classId), function(data) {
        var $select = $('#section_id');
        $select.empty().append('<option value="">{{ __('Select Section') }}</option>');
        Object.entries(data).forEach(function([id, name]) {
            $select.append('<option value="' + id + '">' + name + '</option>');
        });
    });
}
$(function() { $('.datepicker').datepicker({ format: 'dd-mm-yyyy', autoclose: true }); $('.select2').select2(); });
</script>
@endpush
