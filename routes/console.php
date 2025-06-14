<?php

use App\Console\Commands\DispatchDueNotificationsCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(DispatchDueNotificationsCommand::class)
    ->everyMinute();
