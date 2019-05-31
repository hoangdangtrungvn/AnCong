<?php

namespace App\Http\Controllers;

class GeneralPractitionerController extends Controller
{
    public function index()
    {
        // $client = new Client();
        // $response = $client->request('GET', 'https://reqres.in/api/users?page=2');

        // echo $response->getStatusCode(); # 200
        // echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        // echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'

        // # Send an asynchronous request.
        // $request = new \GuzzleHttp\Psr7\Request('GET', 'https://api.github.com/repos/guzzle/guzzle');
        // $promise = $client->sendAsync($request)->then(function ($response) {
        //     echo 'I completed! ' . $response->getBody();
        // });

        // $promise->wait();

        return view('index');
    }
}
