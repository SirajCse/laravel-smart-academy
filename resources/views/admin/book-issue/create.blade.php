@extends('layouts.admin')

@section('title', __('Add Book Issue'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.book-issue.index') }}" class="hover:text-foreground">Book Issue</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Book Issue" description="Create a new book issue record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Book Issue Information</x-card-title>
        <x-card-description>Fill in the details below to create a new book issue record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.book-issue.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Book">
                <x-select name="book_id" :options="[]" placeholder="Select book" />
            </x-form-field>
                <x-form-field label="Member ID">
                <x-input name="member_id" type="text" placeholder="Enter member id..." />
            </x-form-field>
                <x-form-field label="Member Type">
                <x-select name="member_type" :options="[]" placeholder="Select member type" />
            </x-form-field>
                <x-form-field label="Issue Date">
                <x-input name="issue_date" type="date" />
            </x-form-field>
                <x-form-field label="Return Date">
                <x-input name="return_date" type="date" />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Book Issue</x-button>
                <x-button :href="route('admin.book-issue.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
