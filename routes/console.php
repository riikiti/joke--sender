<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:send-sms-command')->hourly();
Schedule::command('app:send-telegram-command')->hourly();