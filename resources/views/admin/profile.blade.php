@extends('layouts.admin')

@section('title', __('My Profile'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <span>Profile</span>
@endsection

@section('content')
<x-page-header title="My Profile" description="View and manage your profile information" />

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    {{-- Profile card --}}
    <x-card class="lg:col-span-1">
        <x-card-content class="flex flex-col items-center text-center">
            <x-avatar :src="$staff->image ? asset('storage/'.$staff->image) : null" :fallback="strtoupper(substr($staff->name ?? '?', 0, 2))" size="xl" />
            <h3 class="mt-4 text-xl font-semibold">{{ $staff->name }}</h3>
            <p class="text-sm text-muted-foreground">{{ $staff->email }}</p>
            <div class="mt-3">
                <x-badge variant="secondary">{{ $staff->roles?->first()?->name ?? 'Staff' }}</x-badge>
            </div>
            <div class="mt-6 w-full">
                <x-button :href="route('admin.staff.edit', $staff)" variant="outline" class="w-full">
                    <i class="fa fa-pencil"></i> Edit Profile
                </x-button>
            </div>
        </x-card-content>
    </x-card>

    {{-- Details card --}}
    <x-card class="lg:col-span-2">
        <x-card-header>
            <x-card-title>Profile Details</x-card-title>
            <x-card-description>Your personal and contact information</x-card-description>
        </x-card-header>
        <x-card-content>
            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Staff ID</dt>
                    <dd class="mt-1 text-sm">{{ $staff->staff_id ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Phone</dt>
                    <dd class="mt-1 text-sm">{{ $staff->phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Department</dt>
                    <dd class="mt-1 text-sm">{{ $staff->department?->department_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Designation</dt>
                    <dd class="mt-1 text-sm">{{ $staff->designation?->designation ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Date of Birth</dt>
                    <dd class="mt-1 text-sm">{{ formatDate($staff->dob) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Joining Date</dt>
                    <dd class="mt-1 text-sm">{{ formatDate($staff->joining_date) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Gender</dt>
                    <dd class="mt-1 text-sm">{{ ucfirst($staff->gender ?? '-') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Status</dt>
                    <dd class="mt-1">
                        <x-badge :variant="$staff->is_active ? 'success' : 'destructive'">
                            {{ $staff->is_active ? 'Active' : 'Inactive' }}
                        </x-badge>
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Address</dt>
                    <dd class="mt-1 text-sm">{{ $staff->address ?? '-' }}</dd>
                </div>
            </dl>
        </x-card-content>
    </x-card>
</div>
@endsection
