<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\User;
use DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Redirect the user to Twitch authentication page if not authenticated; If authenticated, redirect to dashboard..
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::with('twitch')->scopes(['user_read'])->redirect();
    }

    /**
     * Obtains the user information from Twitch.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::with('twitch')->user();
        } catch (Exception $e) {
            return redirect()->route('auth.twitch');
        }

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);
        return redirect()->route('home');
    }

    /**
     * Logs out the user
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $user
     * @return User
     */
    private function findOrCreateUser($user)
    {
        if($authUser = User::where(['_id' => $user->id])->first()) {
            return $authUser;
        }

        return User::create([
            '_id' => $user->id,
            'name' => $user->name,
            'display_name' => $user->user['display_name'],
            'email' => $user->email,
            'avatar' => $user->avatar,
            'approved' => 0,
            'rejected' => 0,
            'admin' => 0
        ]);
    }
}
