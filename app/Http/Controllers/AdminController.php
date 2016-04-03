<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AdminController extends Controller
{
    private $twitchApi;

    /**
     * Initializes the controller with a reference to TwitchApiController.
     */
    public function __construct()
    {
        $this->twitchApi = new TwitchApiController(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
    }

    /**
     * The homepage view for the admin dashboard.
     *
     * @return response
     */
    public function home()
    {
        return view('admin.home', ['page' => 'Admin Home']);
    }

    /**
     * Creates a user (if it doesn't exist) and adds a profile for the user specified.
     *
     * @param Request $request
     * @return response
     */
    public function addUser(Request $request)
    {
        // TODO: Handle user creation.
    }
}
