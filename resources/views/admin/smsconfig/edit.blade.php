@extends('layouts.admin')

@section('title', __('Edit SMS Config'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.smsconfig.index') }}" class="hover:text-foreground">SMS Config</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Edit</span>
@endsection

@section('content')
<x-page-header title="Edit SMS Config" description="Update the sms config record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>SMS Config Information</x-card-title>
        <x-card-description>Update the details below.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.smsconfig.update', $record) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
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
                <x-button type="submit"><i class="fa fa-save"></i> Save Changes</x-button>
                <x-button :href="route('admin.smsconfig.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
