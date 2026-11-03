@extends('layouts.admin')

@section('title', __('Add Book'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.book.index') }}" class="hover:text-foreground">Book</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Book" description="Create a new book record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Book Information</x-card-title>
        <x-card-description>Fill in the details below to create a new book record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.book.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Book Title">
                <x-input name="book_title" type="text" placeholder="Enter book title..." />
            </x-form-field>
                <x-form-field label="Book No">
                <x-input name="book_no" type="text" placeholder="Enter book no..." />
            </x-form-field>
                <x-form-field label="ISBN">
                <x-input name="isbn_no" type="text" placeholder="Enter isbn..." />
            </x-form-field>
                <x-form-field label="Author">
                <x-input name="author" type="text" placeholder="Enter author..." />
            </x-form-field>
                <x-form-field label="Publisher">
                <x-input name="publisher" type="text" placeholder="Enter publisher..." />
            </x-form-field>
                <x-form-field label="Publish Year">
                <x-input name="publish_year" type="text" placeholder="Enter publish year..." />
            </x-form-field>
                <x-form-field label="Quantity">
                <x-input name="qty" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Cost">
                <x-input name="perunitcost" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="Description">
                <x-textarea name="description" placeholder="Enter description..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Book</x-button>
                <x-button :href="route('admin.book.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
