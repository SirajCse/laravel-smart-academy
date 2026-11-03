@extends('layouts.admin')

@section('title', __('Add Email Config'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <a href="{{ route('admin.emailconfig.index') }}" class="hover:text-foreground">Email Config</a>
    <i class="fa fa-chevron-right text-xs"></i> <span>Add New</span>
@endsection

@section('content')
<x-page-header title="Add New Email Config" description="Create a new email config record" />

<x-card class="max-w-3xl">
    <x-card-header>
        <x-card-title>Email Config Information</x-card-title>
        <x-card-description>Fill in the details below to create a new email config record.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.emailconfig.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Mailer">
                <x-select name="mailer" :options="['smtp' => 'SMTP', 'sendmail' => 'Sendmail', 'mailgun' => 'Mailgun', 'ses' => 'Amazon SES']" placeholder="Select mailer" />
            </x-form-field>
                <x-form-field label="SMTP Host">
                <x-input name="smtp_host" type="text" placeholder="Enter smtp host..." />
            </x-form-field>
                <x-form-field label="SMTP Port">
                <x-input name="smtp_port" type="number" step="0.01" />
            </x-form-field>
                <x-form-field label="SMTP Username">
                <x-input name="smtp_username" type="text" placeholder="Enter smtp username..." />
            </x-form-field>
                <x-form-field label="SMTP Password">
                <x-input name="smtp_password" type="password" placeholder="••••••••" />
            </x-form-field>
                <x-form-field label="Encryption">
                <x-select name="encryption" :options="['' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL']" placeholder="Select encryption" />
            </x-form-field>
                <x-form-field label="From Email">
                <x-input name="from_email" type="email" placeholder="email@example.com" />
            </x-form-field>
                <x-form-field label="From Name">
                <x-input name="from_name" type="text" placeholder="Enter from name..." />
            </x-form-field>
            </div>
            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Email Config</x-button>
                <x-button :href="route('admin.emailconfig.index')" variant="outline">Cancel</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
