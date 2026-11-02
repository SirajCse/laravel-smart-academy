<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('fees:reminder')->dailyAt('09:00');
Schedule::command('birthday:sms')->dailyAt('08:00');
Schedule::command('absent:sms')->weekdays()->at('11:00');
Schedule::command('salary:reminder')->monthlyOn(1, '09:00');
Schedule::command('examreport:generate')->cron('0 2 * * *');
Schedule::command('inactive:students')->dailyAt('00:30');
Schedule::command('attendance:sync')->everyFiveMinutes();
Schedule::command('telescope:prune')->daily();
