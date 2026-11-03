@extends('layouts.admin')

@section('title', __('Add Subject'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.subject.index') }}" class="hover:text-foreground">Subject</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Subject" description="Create a new subject record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Subject Information</x-card-title>
        <x-card-description>Fill in the details below to create a new subject record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.subject.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Subject Name">
                <x-input name="name" type="text" placeholder="Enter subject name..." />
            </x-form-field>
                <x-form-field label="Code">
                <x-input name="code" type="text" placeholder="Enter code..." />
            </x-form-field>
                <x-form-field label="Type">
                <x-input name="type" type="text" placeholder="Enter type..." />
            </x-form-field>
                <x-form-field label="Class">
                <x-select name="class_id" :options="[]" placeholder="Select class" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Subject</x-button>
                <x-button :href="route('admin.subject.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
