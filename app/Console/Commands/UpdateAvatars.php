<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Http\Controllers\TwitchApiController;
class UpdateAvatars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:avatars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates avatars for all users';

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
        $users = User::all();

        foreach ($users as $user) {
            $checkUser = $twitchApi->users($user->name);

            if (isset($checkUser['logo']) && $checkUser['logo'] != $user->avatar) {
                $user->avatar = $checkUser['logo'];
                $user->save();
            }
        }
    }
}
