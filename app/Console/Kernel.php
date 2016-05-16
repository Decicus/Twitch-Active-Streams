<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\UpdateAvatars::class,
        Commands\UpdateStreams::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * Checks streams every 5 minutes.
         */
        $schedule->command('update:streams')->everyFiveMinutes();

        /**
         * Updates user avatars weekly.
         */
        $schedule->command('update:avatars')->weekly();
    }
}
