<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
        $bio = '[b]bold[/b]
                [i]italic[/i]
                [u]underline[/u]
                [s]line through[/s]
                [size=6]size[/size]
                [color=#eee]color[/color]
                [center]centered text[/center]
                [quote]quote[/quote]
                [quote=decicus]quote by user[/quote]
                [url]https://www.example.com[/url]
                [url=https://www.example.com]example.com[/url]
                [img]https://i.imgur.com/XNfYO0D.png[/img]
                [list=1]
                    [*]Item 1
                    [*]Item 2
                    [*]Item 3
                [/list]
                [code]print("Hello world")[/code]
                [youtube]dQw4w9WgXcQ[/youtube]
                [list]
                    [*]Item 1
                    [*]Item 2
                    [*]Item 3
                [/list]';

        DB::table('users')->insert([
            '_id' => 25622621,
            'name' => 'decicus',
            'display_name' => 'Decicus',
            'avatar' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/decicus-profile_image-bfdbab4c9490ba74-300x300.jpeg',
            'admin' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            '_id' => 56546952,
            'name' => 'mellownebula',
            'display_name' => 'MellowNebula',
            'avatar' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/mellownebula-profile_image-704775ed06de8eec-300x300.png',
            'admin' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('users')->insert([
            '_id' => 59386909,
            'name' => 'cherrylynnie',
            'display_name' => 'cherrylynnie',
            'avatar' => 'https://static-cdn.jtvnw.net/jtv_user_pictures/cherrylynnie-profile_image-b71bd4660c445612-300x300.jpeg',
            'admin' => 0,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('stream_profiles')->insert([
            '_id' => 25622621,
            'bio' => $bio,
            'last_game' => 'Grand Theft Auto V',
            'last_stream' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('stream_profiles')->insert([
            '_id' => 56546952,
            'bio' => $bio,
            'last_game' => 'Flappy Bird',
            'last_stream' => $now->subMonth(),
            'created_at' => $now,
            'updated_at' => $now
        ]);

        DB::table('stream_profiles')->insert([
            '_id' => 59386909,
            'bio' => $bio,
            'last_game' => 'DayZ',
            'last_stream' => Carbon::now()->addDays(15),
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
