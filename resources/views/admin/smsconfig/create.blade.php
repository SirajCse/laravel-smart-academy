@extends('layouts.admin')

@section('title', __('Add SMS Config'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.smsconfig.index') }}" class="hover:text-foreground">SMS Config</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New SMS Config" description="Create a new sms config record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>SMS Config Information</x-card-title>
        <x-card-description>Fill in the details below to create a new sms config record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.smsconfig.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Provider">
                <x-select name="provider" :options="['twilio' => 'Twilio', 'nexmo' => 'Nexmo', 'msg91' => 'MSG91', 'textlocal' => 'TextLocal', 'plivo' => 'Plivo']" placeholder="Select provider" />
            </x-form-field>
                <x-form-field label="API Key">
                <x-input name="api_key" type="text" placeholder="Enter api key..." />
            </x-form-field>
                <x-form-field label="Sender ID">
                <x-input name="sender_id" type="text" placeholder="Enter sender id..." />
            </x-form-field>
                <x-form-field label="API URL">
                <x-input name="api_url" type="text" placeholder="Enter api url..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save SMS Config</x-button>
                <x-button :href="route('admin.smsconfig.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
