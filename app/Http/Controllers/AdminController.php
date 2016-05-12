<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\StreamProfile;

class AdminController extends Controller
{
    private $twitchApi;
    private $User;
    private $StreamProfile;
    private $errors = [
        'home' => [],
        'user_add' => [
            'missing_params' => [
                'type' => 'warning',
                'text' => 'Missing parameter(s)'
            ],
            'api_error' => [
                'type' => 'warning',
                'text' => 'API error'
            ],
            'already_exists' => [
                'type' => 'danger',
                'text' => 'A stream profile for this user already exists.'
            ]
        ],
        'update_user' => [
            
        ]
    ];

    /**
     * Initializes the controller with a reference to TwitchApiController.
     */
    public function __construct()
    {
        $this->twitchApi = new TwitchApiController(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
        $this->User = new User;
        $this->StreamProfile = new StreamProfile;
    }

    /**
     * The homepage view for the admin dashboard.
     *
     * @return response
     */
    public function home()
    {
        return view('admin.home', ['page' => 'Admin Home', 'errors' => $this->errors['home']]);
    }

    /**
     * Redirects to specified route with error prefix and messages.
     * @param  string $route Route name
     * @param  string $error Name of error specified in $this->errors for the specific route.
     * @param  string $text  Custom error text
     * @return response
     */
    public function error($route = 'home', $error = '', $text = '')
    {
        return redirect()->route('admin.' . $route, ['error' => $error, 'error_text' => $text]);
    }

    /**
     * The view for adding users to database.
     *
     * @param Request $request
     * @return response
     */
    public function addUser(Request $request)
    {
        return view('admin.user.add', ['page' => 'Admin &mdash; Add user', 'errors' => $this->errors['user_add']]);
    }

    /**
     * Creates a user (if it doesn't exist) and adds a profile for the user specified.
     *
     * @param Request $request
     * @return response
     */
    public function addUserPost(Request $request)
    {
        $route = 'user.add';
        $inputs = $request->only(['username', 'bio']);
        $username = strtolower($inputs['username']);
        $bio = $inputs['bio'];
        if (empty($username)) {
            return $this->error($route, 'missing_params', 'Channel name');
        }
        $user = $this->twitchApi->users($username);
        if (!empty($user['status'])) {
            return $this->error($route, 'api_error', $user['error'] . ' &mdash; ' . $user['message']);
        }

        $getUser = $this->User->findOrCreateUser($user);
        $profile = $this->StreamProfile->findOrCreateProfile($user['_id']);
        if (!empty($profile->bio)) {
            return $this->error($route, 'already_exists', '(' . $user['display_name'] . ')');
        }
        $profile->bio = $bio;
        $profile->save();
        return view('admin.user.add', ['page' => 'Admin &mdash; Add user', 'success' => $user['display_name']]);
    }

    public function updateUser(Request $request)
    {
        return view('admin.user.update', ['page' => 'Admin &mdash; Update user', 'errors' => $this->errors['user_update']]);
    }
}
