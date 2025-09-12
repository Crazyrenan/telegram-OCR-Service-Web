<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan; 


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// We are now defining the schedule here instead of in Kernel.php
Schedule::command('report:send-monthly')->everyMinute();

Schedule::command('briefing:send-daily')->dailyAt('10:10');

