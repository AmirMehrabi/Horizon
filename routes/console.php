<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule OpenStack resource sync every 5 minutes
Schedule::command('openstack:sync-resources')
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/openstack-sync.log'));

// Schedule OpenStack instance status sync every minute (for building instances)
Schedule::command('openstack:sync-resources --type=instances')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/openstack-sync.log'));
