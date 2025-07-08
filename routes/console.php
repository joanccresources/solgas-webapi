<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('sanctum:prune-expired --hours=24')->daily();

// Backup schedule
Schedule::command('backup:clean')->daily()->at('02:00');

Schedule::command('backup:run')->daily()->at('02:30');

Schedule::command('backup:monitor')->monthly()->at('03:00');
