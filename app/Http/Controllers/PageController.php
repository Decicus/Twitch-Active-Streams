<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PageController extends Controller
{
    private $errors = [
        'home' => [
            'unauthorized' => ['type' => 'danger', 'text' => 'You do not have access to the admin dashboard.']
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
     * @return response
     */
    public function streams(Request $request)
    {
        // TODO: Create view for streams.
        return redirect()->route('home');
    }
}
