@extends('layouts.admin')

@section('title', __('School Settings'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <span>Settings</span>
@endsection

@section('content')
<x-page-header title="School Settings" description="Configure your school's general information" />

<x-card class="max-w-4xl">
    <x-card-header>
        <x-card-title>School Information</x-card-title>
        <x-card-description>Update your school's basic information and contact details.</x-card-description>
    </x-card-header>
    <x-card-content>
        <form method="POST" action="{{ route('admin.schsettings.index') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="School Name" required>
                    <x-input name="school_name" :value="$record->school_name" required />
                </x-form-field>
                <x-form-field label="School Code">
                    <x-input name="school_code" :value="$record->school_code" />
                </x-form-field>
                <x-form-field label="Email">
                    <x-input name="email" type="email" :value="$record->email" />
                </x-form-field>
                <x-form-field label="Phone">
                    <x-input name="phone" :value="$record->phone" />
                </x-form-field>
                <x-form-field label="Currency">
                    <x-input name="currency" :value="$record->currency" />
                </x-form-field>
                <x-form-field label="Currency Symbol">
                    <x-input name="currency_symbol" :value="$record->currency_symbol" />
                </x-form-field>
                <x-form-field label="Date Format">
                    <x-select name="date_format" :value="$record->date_format" :options="['d-m-Y' => 'd-m-Y', 'm-d-Y' => 'm-d-Y', 'Y-m-d' => 'Y-m-d', 'd/m/Y' => 'd/m/Y', 'm/d/Y' => 'm/d/Y', 'Y/m/d' => 'Y/m/d']" />
                </x-form-field>
                <x-form-field label="Theme">
                    <x-select name="theme" :value="$record->theme" :options="['default' => 'Default', 'bold_blue' => 'Bold Blue', 'darkgray' => 'Dark Gray', 'material_pink' => 'Material Pink', 'shadow_white' => 'Shadow White', 'yellow' => 'Yellow']" />
                </x-form-field>
                <x-form-field label="Timezone">
                    <x-input name="timezone" :value="$record->timezone" />
                </x-form-field>
                <x-form-field label="Office Hours">
                    <x-input name="office_hours" :value="$record->office_hours" />
                </x-form-field>
            </div>

            <x-form-field label="Address" class="mt-4">
                <x-textarea name="address" :value="$record->address" rows="2" />
            </x-form-field>

            <x-form-field label="Copyright Text" class="mt-4">
                <x-input name="copyright" :value="$record->copyright" />
            </x-form-field>

            <h3 class="mt-8 mb-4 text-lg font-semibold">Social Media</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <x-form-field label="Facebook">
                    <x-input name="facebook_url" :value="$record->facebook_url" placeholder="https://facebook.com/..." />
                </x-form-field>
                <x-form-field label="Twitter">
                    <x-input name="twitter_url" :value="$record->twitter_url" placeholder="https://twitter.com/..." />
                </x-form-field>
                <x-form-field label="YouTube">
                    <x-input name="youtube_url" :value="$record->youtube_url" placeholder="https://youtube.com/..." />
                </x-form-field>
                <x-form-field label="LinkedIn">
                    <x-input name="linkedin_url" :value="$record->linkedin_url" placeholder="https://linkedin.com/..." />
                </x-form-field>
                <x-form-field label="Instagram">
                    <x-input name="instagram_url" :value="$record->instagram_url" placeholder="https://instagram.com/..." />
                </x-form-field>
                <x-form-field label="Pinterest">
                    <x-input name="pinterest_url" :value="$record->pinterest_url" placeholder="https://pinterest.com/..." />
                </x-form-field>
            </div>

            <div class="mt-6 flex items-center gap-2">
                <x-button type="submit"><i class="fa fa-save"></i> Save Settings</x-button>
                <x-button :href="route('admin.schsettings.backup')" variant="outline"><i class="fa fa-database"></i> Backup</x-button>
                <x-button :href="route('admin.schsettings.audit')" variant="ghost"><i class="fa fa-history"></i> Audit Log</x-button>
            </div>
        </form>
    </x-card-content>
</x-card>
@endsection
