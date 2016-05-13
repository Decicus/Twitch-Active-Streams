<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
                'text' => 'A stream profile for this channel already exists.'
            ]
        ],
        'user_edit' => [
            'invalid_channel' => [
                'type' => 'warning',
                'text' => 'Channel does not have a stream profile.'
            ]
        ],
        'user_delete' => [
            'invalid_channel' => [
                'type' => 'warning',
                'text' => 'Channel does not have a stream profile.'
            ]
        ],
        'user_restore' => [
            'invalid_channel' => [
                'type' => 'danger',
                'text' => 'Channel does not have an existing stream profile in database.'
            ],
            'active_channel' => [
                'type' => 'warning',
                'text' => 'This channel is already active.'
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
                'text' => 'Add profile',
                'fa' => 'fa-user-plus',
                'class' => 'text-success'
            ],
            'admin.user.edit' => [
                'text' => 'Edit profile',
                'fa' => 'fa-pencil-square-o',
                'class' => 'text-warning'
            ],
            'admin.user.delete' => [
                'text' => 'Delete profile',
                'fa' => 'fa-user-times',
                'class' => 'text-danger'
            ],
            'admin.user.restore' => [
                'text' => 'Restore profile',
                'fa' => 'fa-user-secret',
                'class' => 'text-info'
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
        $params = [
            'error' => $error
        ];

        if (!empty($text)) {
            $params['error_text'] = $text;
        }

        return redirect()->route('admin.' . $route, $params);
    }

    /**
     * The view for adding users and profiles to the database.
     *
     * @param Request $request
     * @return response
     */
    public function addUser(Request $request)
    {
        $viewData = [
            'page' => 'Admin &mdash; Add profile',
            'errors' => $this->errors['user_add']
        ];

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
            if (!empty($profile->bio) && !$profile->trashed()) {
                return $this->error($route, 'already_exists', '(' . $user['display_name'] . ')');
            }

            if ($profile->trashed()) {
                $profile->restore();
            }

            $stream = $this->twitchApi->streams($username);
            if (!empty($stream['stream'])) {
                $profile->last_stream = $stream['stream']['created_at'];
            }

            $profile->last_game = htmlspecialchars($user['game']);
            $profile->bio = htmlspecialchars($bio);
            $profile->save();
            $viewData['success'] = $user['display_name'];
        }
        return view('admin.user.add', $viewData);
    }

    /**
     * The view for editing a specified profile.
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
            'page' => 'Admin &mdash; Edit profile',
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

    /**
     * The view for deleting a profile.
     *
     * @param  Request $request
     * @return Response
     */
    public function deleteUser(Request $request)
    {
        $route = 'user.delete';
        $viewData = [
            'page' => 'Admin &mdash; Delete profile',
            'errors' => $this->errors['user_delete']
        ];

        if ($request->isMethod('post')) {
            $user_id = intval($request->user);
            $profile = $this->StreamProfile->findById($user_id);
            if (empty($profile)) {
                return $this->error($route, 'invalid_channel');
            }

            $viewData['profile'] = $profile;
            $viewData['success'] = $profile->user->display_name;
            $profile->delete();
        }

        $viewData['all_profiles'] = StreamProfile::all();
        return view('admin.user.delete', $viewData);
    }

    public function restoreUser(Request $request)
    {
        $route = 'user.restore';
        $viewData = [
            'page' => 'Admin &mdash; Restore profile',
            'errors' => $this->errors['user_restore']
        ];

        if ($request->isMethod('post')) {
            $user_id = intval($request->user);
            $profile = $this->StreamProfile->findTrashed($user_id);

            if (empty($profile)) {
                if ($this->StreamProfile->findById($user_id)) {
                    return $this->error($route, 'active_channel');
                }
                return $this->error($route, 'invalid_channel');
            }

            $stream = $this->twitchApi->streams($profile->user->name);
            if (!empty($stream['stream'])) {
                $profile->last_stream = $stream['stream']['created_at'];
            }

            $profile->restore();
            $viewData['profile'] = $profile;
            $viewData['success'] = $profile->user->display_name;
        }
        $viewData['trashed_profiles'] = StreamProfile::onlyTrashed()->get();
        return view('admin.user.restore', $viewData);
    }
}
