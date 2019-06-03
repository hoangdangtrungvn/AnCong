<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleHttpRequest;
use Illuminate\Http\Request;

class CoordinatorController extends BaseController
{
    public function index(Request $request)
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        try {
            if (isset($request->order)) {
                if ($request->order == 'oldest') {
                    $req = new GuzzleHttpRequest('GET', '/users/oldest');
                } else {
                    $req = new GuzzleHttpRequest('GET', '/users');
                }
            } else if (isset($request->status)) {
                if ($request->status == 'true') {
                    $req = new GuzzleHttpRequest('GET', '/users/assigned');
                } else {
                    $req = new GuzzleHttpRequest('GET', '/users/assigned_not');
                }
            } else {
                $req = new GuzzleHttpRequest('GET', '/users');
            }

            $response = $client->send($req, [
                'headers' => session('token_auth'),
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        if ($response->getStatusCode() == 401) {
            return redirect()->route('logout');
        }

        $data = json_decode($response->getBody(), true);

        $users = $data['users'];
        $doctors = $data['doctors'];
        $dieticians = $data['dieticians'];

        return view('coordinator.index')->with([
            'users'      => $users,
            'doctors'    => $doctors,
            'dieticians' => $dieticians,
        ]);
    }

    public function assign(Request $request)
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        if ($request->doctor_uri == '/assign/dietician') {
            $req = new GuzzleHttpRequest('POST', $request->doctor_uri);
            $response = $client->send($req, [
                'headers'     => session('token_auth'),
                'form_params' => [
                    'user_id'      => $request->user_id,
                    'dietician_id' => $request->doctor_id,
                ],
            ]);

            if ($response->getStatusCode() == 401) {
                return redirect()->route('logout');
            }

            return redirect()->route('coordinators.index')->with('alert', [
                'class'   => 'alert-success',
                'icon'    => 'fa fa-check',
                'message' => 'Gán thành công.',
            ]);
        }

        if ($request->doctor_uri == '/assign/doctor') {
            $req = new GuzzleHttpRequest('POST', $request->doctor_uri);
            $response = $client->send($req, [
                'headers'     => session('token_auth'),
                'form_params' => [
                    'user_id'   => $request->user_id,
                    'doctor_id' => $request->doctor_id,
                ],
            ]);

            if ($response->getStatusCode() == 401) {
                return redirect()->route('logout');
            }

            return redirect()->route('coordinators.index')->with('alert', [
                'class'   => 'alert-success',
                'icon'    => 'fa fa-check',
                'message' => 'Gán thành công.',
            ]);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
