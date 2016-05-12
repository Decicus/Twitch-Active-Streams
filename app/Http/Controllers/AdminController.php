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
        'user_edit' => [
            'invalid_channel' => [
                'type' => 'warning',
                'text' => 'Channel does not have a stream profile'
            ]
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
        $pages = [
            'admin.user.add' => [
                'text' => 'Add user',
                'fa' => 'fa-user-plus',
                'class' => 'list-group-item-success'
            ],
            'admin.user.edit' => [
                'text' => 'Edit user',
                'fa' => 'fa-pencil-square',
                'class' => 'list-group-item-warning'
            ]
        ];
        return view('admin.home', ['page' => 'Admin Home', 'errors' => $this->errors['home'], 'pages' => $pages]);
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
        if ($request->isMethod('post')) {
            $route = 'user.add';
            $inputs = $request->only(['username', 'bio']);
            $username = strtolower($inputs['username']);
            $bio = $inputs['bio'];
            if (empty($username)) {
                return $this->error($route, 'missing_params', 'Channel name');
            }
            $user = $this->twitchApi->channels($username);
            if (!empty($user['error'])) {
                return $this->error($route, 'api_error', $user['error'] . ' &mdash; ' . $user['message']);
            }

            $getUser = $this->User->findOrCreateUser($user);
            $profile = $this->StreamProfile->findOrCreateProfile($user['_id']);
            if (!empty($profile->bio)) {
                return $this->error($route, 'already_exists', '(' . $user['display_name'] . ')');
            }

            $stream = $this->twitchApi->streams($username);
            if (!empty($stream['stream'])) {
                $profile->last_stream = $stream['stream']['created_at'];
            }

            $profile->last_game = htmlspecialchars($user['game']);
            $profile->bio = htmlspecialchars($bio);
            $profile->save();
            return view('admin.user.add', ['page' => 'Admin &mdash; Add channel', 'success' => $user['display_name']]);
        }
        return view('admin.user.add', ['page' => 'Admin &mdash; Add channel', 'errors' => $this->errors['user_add']]);
    }

    /**
     * The view for editing a specified user.
     *
     * @param  Request $request
     * @param  string  $username
     * @return Response
     */
    public function editUser(Request $request, $username = null)
    {
        $route = 'user.edit';
        $inputs = $request->only(['username', 'bio']);
        $viewData = [
            'page' => 'Admin &mdash; Edit user',
            'errors' => $this->errors['user_edit']
        ];

        if (empty($username)) {
            $profiles = StreamProfile::all();
            $viewData['all_profiles'] = $profiles;
        } else {
            $username = strtolower($username);
            $user = $this->User->findByName($username);
            $profile = $this->StreamProfile->findById($user['_id']);
            if (empty($user) || empty($profile)) {
                return $this->error($route, 'invalid_channel');
            }
            $viewData['profile'] = $profile;
        }

        if ($request->isMethod('post')) {
            $bio = $inputs['bio'];
            $profile->bio = htmlspecialchars($bio);
            $profile->save();
            $viewData['profile'] = $profile;
            $viewData['success'] = $user['display_name'];
        }
        return view('admin.user.edit', $viewData);
    }
}
