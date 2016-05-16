<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\StreamProfile;
use App\Http\Controllers\TwitchApiController;
class UpdateStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:streams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks all available stream profiles, and updates their stream status if necessary.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $twitchApi = new TwitchApiController(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
        $profiles = StreamProfile::all();

        foreach ($profiles as $profile) {
            $stream = $twitchApi->streams($profile->user->name);
            if (!empty($stream['stream'])) {
                $profile->last_stream = $stream['stream']['created_at'];
                $profile->last_game = $stream['stream']['game'];
                $profile->save();
            }
        }
    }
}
