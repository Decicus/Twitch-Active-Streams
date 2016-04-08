<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{
    private $headers = [
        'Access-Control-Allow-Origin' => '*'
    ];

    protected function respJson($data = [], $code = 200, $headers = [])
    {
        $headers = array_merge($this->headers, $headers);
        return response($data, $code)->json()->withHeaders($headers);
    }

    public function base()
    {

    }
}
