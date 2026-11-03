@extends('layouts.admin')

@section('title', __('Dashboard'))
@section('breadcrumbs')
    <i class="fa fa-chevron-right text-xs"></i> <span>Dashboard</span>
@endsection

@section('content')
<x-page-header
    title="Dashboard"
    description="Welcome back, {{ $staffName ?? 'Admin' }}! Here's what's happening at your school today."
/>

{{-- Stat cards --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-stat-card
        title="Total Students"
        :value="number_format($stats['students'] ?? 0)"
        icon="fa-user-graduate"
        color="info"
        :trend="['value' => '+5.2%', 'direction' => 'up', 'label' => 'this month']"
    />
    <x-stat-card
        title="Total Staff"
        :value="number_format($stats['staff'] ?? 0)"
        icon="fa-users"
        color="primary"
        :trend="['value' => '+2', 'direction' => 'up', 'label' => 'this month']"
    />
    <x-stat-card
        title="Fees Collected Today"
        :value="formatCurrency($stats['fees_collected'] ?? 0)"
        icon="fa-money"
        color="success"
        :trend="['value' => '+12.5%', 'direction' => 'up', 'label' => 'vs yesterday']"
    />
    <x-stat-card
        title="Pending Fees"
        :value="formatCurrency($stats['pending_fees'] ?? 0)"
        icon="fa-exclamation-circle"
        color="warning"
        :trend="['value' => '-3.1%', 'direction' => 'down', 'label' => 'vs last week']"
    />
</div>

{{-- Charts row --}}
<div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
    {{-- Fees collection chart --}}
    <x-card class="lg:col-span-2">
        <x-card-header>
            <x-card-title>Fees Collection — Last 7 Days</x-card-title>
            <x-card-description>Daily fee collection amount over the past week</x-card-description>
        </x-card-header>
        <x-card-content>
            <div style="height: 280px;">
                <canvas id="feesChart"></canvas>
            </div>
        </x-card-content>
    </x-card>

    {{-- Attendance donut --}}
    <x-card>
        <x-card-header>
            <x-card-title>Attendance Today</x-card-title>
            <x-card-description>Overall student attendance percentage</x-card-description>
        </x-card-header>
        <x-card-content>
            <div style="height: 280px;">
                <canvas id="attendanceChart"></canvas>
            </div>
        </x-card-content>
    </x-card>
</div>

{{-- Two-column section: Recent admissions + Upcoming events --}}
<div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
    {{-- Recent admissions --}}
    <x-card class="lg:col-span-2">
        <x-card-header class="flex-row items-center justify-between">
            <div>
                <x-card-title>Recent Admissions</x-card-title>
                <x-card-description>Latest students enrolled at the school</x-card-description>
            </div>
            <x-button :href="route('admin.student.index')" variant="outline" size="sm">
                View all <i class="fa fa-arrow-right text-xs"></i>
            </x-button>
        </x-card-header>
        <x-card-content>
            @if (count($recentStudents ?? []) > 0)
                <div class="rounded-md border">
                    <table class="w-full" data-datatable='{"pageLength": 5, "lengthChange": false, "info": false, "searching": false}'>
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Student</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Admission No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Class</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-muted-foreground">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentStudents as $student)
                                <tr class="border-b last:border-0 hover:bg-muted/50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <x-avatar :src="$student->image ? asset('storage/'.$student->image) : null" :fallback="strtoupper(substr($student->firstname ?? '?', 0, 1))" size="sm" />
                                            <div>
                                                <div class="text-sm font-medium">{{ $student->firstname }} {{ $student->lastname }}</div>
                                                <div class="text-xs text-muted-foreground">{{ $student->email ?? $student->mobileno ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ $student->admission_no }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $student->sessions->first()?->class?->class ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm">{{ formatDate($student->admission_date) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-muted text-muted-foreground">
                        <i class="fa fa-user-graduate text-xl"></i>
                    </div>
                    <p class="mt-3 text-sm font-medium">No recent admissions</p>
                    <p class="text-xs text-muted-foreground">New students will appear here.</p>
                </div>
            @endif
        </x-card-content>
    </x-card>

    {{-- Upcoming events --}}
    <x-card>
        <x-card-header>
            <x-card-title>Upcoming Events</x-card-title>
            <x-card-description>Holidays & events in the coming days</x-card-description>
        </x-card-header>
        <x-card-content>
            @forelse ($events ?? [] as $event)
                <div class="mb-3 flex items-start gap-3 rounded-md border p-3">
                    <div class="flex h-10 w-10 flex-col items-center justify-center rounded-md bg-info/10 text-info">
                        <span class="text-xs font-semibold leading-none">{{ \Carbon\Carbon::parse($event->from_date)->format('M') }}</span>
                        <span class="text-base font-bold leading-none">{{ \Carbon\Carbon::parse($event->from_date)->format('d') }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ $event->title }}</p>
                        <p class="text-xs text-muted-foreground">{{ formatDate($event->from_date) }} → {{ formatDate($event->to_date) }}</p>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-muted text-muted-foreground">
                        <i class="fa fa-calendar text-xl"></i>
                    </div>
                    <p class="mt-3 text-sm font-medium">No upcoming events</p>
                    <p class="text-xs text-muted-foreground">Holidays will appear here.</p>
                </div>
            @endforelse
        </x-card-content>
    </x-card>
</div>

{{-- Quick actions --}}
<div class="mt-6">
    <x-card>
        <x-card-header>
            <x-card-title>Quick Actions</x-card-title>
            <x-card-description>Common tasks you can perform quickly</x-card-description>
        </x-card-header>
        <x-card-content>
            <div class="grid grid-cols-2 gap-3 md:grid-cols-4 lg:grid-cols-6">
                <a href="{{ route('admin.student.create') }}" class="flex flex-col items-center gap-2 rounded-md border p-4 text-center hover:bg-accent">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-info/10 text-info"><i class="fa fa-user-plus"></i></div>
                    <span class="text-xs font-medium">Add Student</span>
                </a>
                <a href="{{ route('admin.staff.create') }}" class="flex flex-col items-center gap-2 rounded-md border p-4 text-center hover:bg-accent">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary"><i class="fa fa-user-plus"></i></div>
                    <span class="text-xs font-medium">Add Staff</span>
                </a>
                <a href="{{ route('admin.student-fee.index') }}" class="flex flex-col items-center gap-2 rounded-md border p-4 text-center hover:bg-accent">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-success/10 text-success"><i class="fa fa-money"></i></div>
                    <span class="text-xs font-medium">Collect Fee</span>
                </a>
                <a href="{{ route('admin.homework.create') }}" class="flex flex-col items-center gap-2 rounded-md border p-4 text-center hover:bg-accent">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-warning/10 text-warning"><i class="fa fa-pencil"></i></div>
                    <span class="text-xs font-medium">Homework</span>
                </a>
                <a href="{{ route('admin.income.create') }}" class="flex flex-col items-center gap-2 rounded-md border p-4 text-center hover:bg-accent">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-success/10 text-success"><i class="fa fa-plus-circle"></i></div>
                    <span class="text-xs font-medium">Add Income</span>
                </a>
                <a href="{{ route('admin.expense.create') }}" class="flex flex-col items-center gap-2 rounded-md border p-4 text-center hover:bg-accent">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-destructive/10 text-destructive"><i class="fa fa-minus-circle"></i></div>
                    <span class="text-xs font-medium">Add Expense</span>
                </a>
            </div>
        </x-card-content>
    </x-card>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('feesChart');
if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [{
                label: 'Collected',
                data: @json($chartValues ?? []),
                backgroundColor: 'hsl(142.1 76.2% 36.3% / 0.7)',
                borderColor: 'hsl(142.1 76.2% 36.3%)',
                borderWidth: 1,
                borderRadius: 6,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: v => '$' + v },
                    grid: { color: 'hsl(214.3 31.8% 91.4%)' },
                },
                x: { grid: { display: false } },
            },
        },
    });
}

const ctx2 = document.getElementById('attendanceChart');
if (ctx2) {
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent', 'Late'],
            datasets: [{
                data: [85, 10, 5],
                backgroundColor: [
                    'hsl(142.1 76.2% 36.3%)',
                    'hsl(0 84.2% 60.2%)',
                    'hsl(38 92% 50%)',
                ],
                borderWidth: 0,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { position: 'bottom' } },
        },
    });
}
</script>
@endpush
