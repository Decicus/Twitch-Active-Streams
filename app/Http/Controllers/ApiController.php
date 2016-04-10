<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\StreamProfile;
use \Golonka\BBCode\BBCodeParser;

class ApiController extends Controller
{
    private $headers = [
        'Access-Control-Allow-Origin' => '*'
    ];

    /**
     * Returns a JSON response
     * @param  array  $data    Array of data to send in the response
     * @param  integer $code    The HTTP status code
     * @param  array  $headers The HTTP headers to send
     * @return response
     */
    protected function respJson($data = [], $code = 200, $headers = [])
    {
        $headers = array_merge($this->headers, $headers);
        return \Response::json($data, $code)->withHeaders($headers);
    }

    /**
     * Base of API
     *
     * @return response
     */
    public function base()
    {
        $base = url('/api');
        return $this->respJson([
            'links' => [
                'base' => $base,
                'streams' => $base . '/streams',
                'admin' => $base . '/admin'
            ]
        ]);
    }
}
