@extends('layouts.admin')

@section('title', __('Add Section'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.section.index') }}" class="hover:text-foreground">Section</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Section" description="Create a new section record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Section Information</x-card-title>
        <x-card-description>Fill in the details below to create a new section record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.section.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Section Name">
                <x-input name="section" type="text" placeholder="Enter section name..." />
            </x-form-field>
                <x-form-field label="Note">
                <x-textarea name="note" placeholder="Enter note..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Section</x-button>
                <x-button :href="route('admin.section.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
