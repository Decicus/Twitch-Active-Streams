<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PageController extends Controller
{
    private $errors = [
        'home' => [
            'unauthorized_admin' => ['type' => 'danger', 'text' => 'You do not have access to the admin dashboard.']
        ]
    ];

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
        if(empty($user)) {
            return view('streams.main', ['page' => 'Streams']);
        }

        return view('streams.user', ['user' => $user, 'page' => 'Streams']);
    }
}
