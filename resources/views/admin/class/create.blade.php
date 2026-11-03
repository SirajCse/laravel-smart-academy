@extends('layouts.admin')

@section('title', __('Add Class'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.class.index') }}" class="hover:text-foreground">Class</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Class" description="Create a new class record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Class Information</x-card-title>
        <x-card-description>Fill in the details below to create a new class record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.class.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Class Name">
                <x-input name="class" type="text" placeholder="Enter class name..." />
            </x-form-field>
                <x-form-field label="Note">
                <x-textarea name="note" placeholder="Enter note..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Class</x-button>
                <x-button :href="route('admin.class.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
