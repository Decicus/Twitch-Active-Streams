<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\StreamProfile;
use App\Http\Controllers\TwitchApiController;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $twitchApi = new TwitchApiController(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
        $schedule->call(function() {
            $profiles = StreamProfile::all();

            foreach ($profiles as $profile) {
                $stream = $twitchApi->streams($profile->user->name);
                if (!empty($stream['stream'])) {
                    $profile->last_stream = $stream['stream']['created_at'];
                    $profile->last_game = $stream['stream']['game'];
                    $profile->save();
                }
            }
        })->everyFiveMinutes();
    }
}
