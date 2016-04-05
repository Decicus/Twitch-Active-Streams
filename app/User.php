<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_id', 'name', 'display_name', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'admin'
    ];

    /**
     * Finds user by their name.
     *
     * @param  string $name Twitch name
     * @return App\User
     */
    public function findByName($name = '')
    {
        return $this::where(['name' => $name])->first();
    }

    /**
     * Return user based on values from the Twitch users API; create if it doesn't exist.
     *
     * @param array $user
     * @return User
     */
    public function findOrCreateUser($user)
    {
        if ($authUser = User::where(['_id' => $user['_id']])->first()) {
            return $authUser;
        }

        return User::create([
            '_id' => $user['_id'],
            'name' => $user['name'],
            'display_name' => $user['display_name'],
            'avatar' => $user['logo'],
            'admin' => 0
        ]);
    }
}
