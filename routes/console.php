<?php

use Illuminate\Support\Facades\Schedule;

// Other
// ...

// Default
if ($this->app->isLocal()) {
    Schedule::command('telescope:prune')->daily()->withoutOverlapping();
}

if ($this->app->isProduction()) {
    Schedule::command('optimize:clear')->weekly()->withoutOverlapping();
    Schedule::command('optimize')->weekly()->withoutOverlapping();
}

Schedule::command('cache:prune-stale-tags')->hourly()->withoutOverlapping();
Schedule::command('model:prune')->daily()->withoutOverlapping();
Schedule::command('sanctum:prune-expired')->daily()->withoutOverlapping();
Schedule::command('auth:clear-resets')->daily()->withoutOverlapping();
Schedule::command('queue:retry all')->daily()->withoutOverlapping();
