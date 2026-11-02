@extends('layouts.admin')

@section('title', __('Backup'))
@section('content_header', __('Database Backup'))

@section('content')
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">{{ __('Backup & Restore') }}</h3></div>
    <div class="box-body">
        <p>{{ __('Create a database backup or restore from a previous backup file.') }}</p>
        <form method="POST" action="{{ route('admin.schsettings.backup') }}" enctype="multipart/form-data">
            @csrf
            <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> {{ __('Create Backup') }}</button>
        </form>
        <hr>
        <form method="POST" action="{{ route('admin.schsettings.restore') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>{{ __('Restore from file') }}</label>
                <input type="file" name="backup_file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning"><i class="fa fa-upload"></i> {{ __('Restore') }}</button>
        </form>
    </div>
</div>
@endsection
