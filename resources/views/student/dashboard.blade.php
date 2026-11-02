@extends('layouts.student')

@section('title', __('Dashboard'))

@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner"><h3>{{ $fees['total'] ?? 0 }}</h3><p>{{ __('Total Fees') }}</p></div>
            <div class="icon"><i class="fa fa-money"></i></div>
            <a href="{{ route('student.fees.index') }}" class="small-box-footer">{{ __('View') }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner"><h3>{{ $fees['paid'] ?? 0 }}</h3><p>{{ __('Paid') }}</p></div>
            <div class="icon"><i class="fa fa-check"></i></div>
            <a href="{{ route('student.fees.index') }}" class="small-box-footer">{{ __('View') }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner"><h3>{{ $fees['due'] ?? 0 }}</h3><p>{{ __('Due') }}</p></div>
            <div class="icon"><i class="fa fa-exclamation"></i></div>
            <a href="{{ route('student.fees.index') }}" class="small-box-footer">{{ __('View') }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner"><h3>{{ $attendancePct ?? 0 }}%</h3><p>{{ __('Attendance') }}</p></div>
            <div class="icon"><i class="fa fa-calendar-check-o"></i></div>
            <a href="{{ route('student.attendance.index') }}" class="small-box-footer">{{ __('View') }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border"><h3 class="box-title">{{ __('Recent Homework') }}</h3></div>
            <div class="box-body">
                <ul class="todo-list">
                    @forelse($homeworks ?? [] as $hw)
                        <li>
                            <span class="text">{{ $hw->subject?->name }} - {{ $hw->description }}</span>
                            <small class="label label-danger"><i class="fa fa-clock-o"></i> {{ formatDate($hw->submit_date) }}</small>
                        </li>
                    @empty
                        <li class="text-muted">{{ __('No pending homework') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border"><h3 class="box-title">{{ __('Notifications') }}</h3></div>
            <div class="box-body">
                @forelse($notifications ?? [] as $notif)
                    <div class="info-box bg-{{ $notif->is_read ? 'gray' : 'aqua' }}">
                        <span class="info-box-icon"><i class="fa fa-bell"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ $notif->title }}</span>
                            <span class="info-box-number">{{ \Str::limit($notif->message, 60) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">{{ __('No notifications') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
