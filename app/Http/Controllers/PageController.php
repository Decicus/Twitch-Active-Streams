<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\StreamProfile;

class PageController extends Controller
{
    private $User;
    private $StreamProfile;
    private $Parser;
    private $errors = [
        'home' => [
            'unauthorized_admin' => ['type' => 'danger', 'text' => 'You do not have access to the admin dashboard.']
        ],
        'streams.main' => [
            'user_not_found' => ['type' => 'warning', 'text' => 'User not found'],
            'user_no_profile' => ['type' => 'warning', 'text' => 'User has no stream profile']
        ]
    ];

    /**
     * Initializes controller.
     */
    public function __construct()
    {
        $this->User = new User;
        $this->StreamProfile = new StreamProfile;
    }

    /**
     * The view for the homepage.
     *
     * @return response
     */
    public function home()
    {
        return view('general.home', ['errors' => $this->errors['home'], 'page' => 'Home']);
    }

    /**
     * The view of the streams page.
     *
     * @param  Request $request
     * @param  string  $user Username of the Twitch user.
     * @return response
     */
    public function streams(Request $request, $user = null)
    {
        if (empty($user)) {
			$streamProfile = $this->StreamProfile;
            $profiles = $streamProfile::all();
            return view('streams.main', ['page' => 'Streams', 'errors' => $this->errors['streams.main'], 'profiles' => $profiles]);
        }

        $getUser = $this->User->findByName($user);
        if (!$getUser) {
            return redirect()->route('streams.main', ['error' => 'user_not_found', 'error_text' => $user]);
        }

        $streamProfile = $this->StreamProfile->findById($getUser->_id);

        if (!$streamProfile) {
            return redirect()->route('streams.main', ['error' => 'user_no_profile', 'error_text' => $getUser->display_name]);
        }

        return view('streams.user', ['user' => $getUser, 'profile' => $streamProfile, 'page' => 'Streams &mdash; ' . $getUser->display_name]);
    }
}
