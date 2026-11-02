@extends('layouts.admin')

@section('title', __('Dashboard'))
@section('content_header', __('Dashboard'))

@section('content')
<div class="row">
    {{-- Quick stats --}}
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner"><h3>{{ $stats['students'] ?? 0 }}</h3><p>{{ __('Total Students') }}</p></div>
            <div class="icon"><i class="fa fa-user"></i></div>
            <a href="{{ route('admin.student.index') }}" class="small-box-footer">{{ __('View All') }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner"><h3>{{ $stats['staff'] ?? 0 }}</h3><p>{{ __('Total Staff') }}</p></div>
            <div class="icon"><i class="fa fa-users"></i></div>
            <a href="{{ route('admin.staff.index') }}" class="small-box-footer">{{ __('View All') }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner"><h3>{{ $stats['fees_collected'] ?? 0 }}</h3><p>{{ __('Fees Collected (today)') }}</p></div>
            <div class="icon"><i class="fa fa-money"></i></div>
            <a href="{{ route('admin.student-fee.index') }}" class="small-box-footer">{{ __('View All') }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner"><h3>{{ $stats['pending_fees'] ?? 0 }}</h3><p>{{ __('Pending Fees') }}</p></div>
            <div class="icon"><i class="fa fa-exclamation-circle"></i></div>
            <a href="{{ route('admin.reports.fee') }}" class="small-box-footer">{{ __('View Report') }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">{{ __('Fees Collection - Last 7 Days') }}</h3></div>
            <div class="box-body">
                <canvas id="feesChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header with-border"><h3 class="box-title">{{ __('Upcoming Events') }}</h3></div>
            <div class="box-body">
                @forelse($events ?? [] as $event)
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ $event->title }}</span>
                            <span class="info-box-number">{{ formatDate($event->from_date) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">{{ __('No upcoming events') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border"><h3 class="box-title">{{ __('Recent Admissions') }}</h3></div>
            <div class="box-body table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr><th>#</th><th>{{ __('Name') }}</th><th>{{ __('Admission No') }}</th><th>{{ __('Class') }}</th><th>{{ __('Date') }}</th></tr>
                    </thead>
                    <tbody>
                    @forelse($recentStudents ?? [] as $i => $student)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td><a href="{{ route('admin.student.show', $student) }}">{{ $student->firstname }} {{ $student->lastname }}</a></td>
                            <td>{{ $student->admission_no }}</td>
                            <td>{{ $student->sessions->first()?->class?->class ?? '-' }}</td>
                            <td>{{ formatDate($student->admission_date) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">{{ __('No recent admissions') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('backend/plugins/chartjs/Chart.min.js') }}"></script>
<script>
new Chart(document.getElementById('feesChart'), {
    type: 'bar',
    data: {
        labels: @json($chartLabels ?? []),
        datasets: [{ label: '{{ __('Collected') }}', data: @json($chartValues ?? []), backgroundColor: '#00a65a' }]
    },
    options: { responsive: true, scales: { yAxes: [{ ticks: { beginAtZero: true } }] } }
});
</script>
@endpush
