<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Http\Controllers\TwitchApiController;
use App\User;
use App\StreamProfile;
class UserAndProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $admins = ['decicus', 'cherrylynnie'];
        $users = [
            'decicus',
            'cherrylynnie',
            'mellownebula',
            'xsmak',
            'iwinuloselol',
            'shroomztv',
            'cjtherocker',
            'halifaxafilah',
            'thepaindog',
            'gamerchr15',
            'ham_carlwinslow',
            'monstercat'
        ];

        $twitch = new TwitchApiController(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
        foreach ($users as $name) {
            $stream = $twitch->streams($name);
            $channel = $twitch->channels($name);
            $user = $twitch->users($name);
            $admin = (in_array($name, $admins) ? 1 : 0);

            if (!empty($channel['_id'])) {
                $bio = empty($user['bio']) ? '[url=https://www.twitch.tv/' . $name . ']' . $channel['display_name'] . '[/url]' : $user['bio'];
                User::create([
                    '_id' => $channel['_id'],
                    'name' => $name,
                    'display_name' => $channel['display_name'],
                    'avatar' => $channel['logo'],
                    'admin' => $admin
                ]);

                StreamProfile::create([
                    '_id' => $channel['_id'],
                    'bio' => $bio,
                    'last_game' => $channel['game'],
                    'last_stream' => null
                ]);
            }
        }
    }
}
