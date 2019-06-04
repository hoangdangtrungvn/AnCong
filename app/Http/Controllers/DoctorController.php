<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleHttpRequest;
use Illuminate\Http\Request;

class DoctorController extends BaseController
{
    public function index(Request $request)
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        try {
            $req = new GuzzleHttpRequest('GET', '/doctor/users');

            $response = $client->send($req, [
                'headers' => session('token_auth'),
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        if ($response->getStatusCode() == 401) {
            return redirect()->route('logout');
        }

        $data = json_decode($response->getBody());

        $users = $data->users;
        $specialists = $data->specialists;

        return view('doctor.index')->with([
            'users'       => $users,
            'specialists' => $specialists,
        ]);
    }

    public function assign(Request $request)
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        $req = new GuzzleHttpRequest('POST', '/doctor/assign/specialist');

        $response = $client->send($req, [
            'headers'     => session('token_auth'),
            'form_params' => [
                'question_id'   => $request->question_id,
                'specialist_id' => $request->specialist_id,
            ],
        ]);

        if ($response->getStatusCode() == 401) {
            return redirect()->route('logout');
        }

        return redirect()->route('doctors.index')->with('alert', [
            'class'   => 'alert-success',
            'icon'    => 'fa fa-check',
            'message' => 'Gán thành công.',
        ]);
    }

    public function question($id)
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        try {
            $req = new GuzzleHttpRequest('GET', '/question/' . $id);

            $response = $client->send($req, [
                'headers' => session('token_auth'),
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        if ($response->getStatusCode() == 401) {
            return redirect()->route('logout');
        }

        $data = json_decode($response->getBody());

        $user = $data->user;
        $question = $data->question;
        $images = $data->images;
        $specialists = $data->specialists;
        $user_records = $data->user_records;
        $doctor_records = $data->doctor_records;
        $record_count = $data->record_count;

        return view('doctor.question')->with([
            'user'           => $user,
            'question'       => $question,
            'images'         => $images,
            'specialists'    => $specialists,
            'record_count'   => $record_count,
            'user_records'   => $user_records,
            'doctor_records' => $doctor_records,
        ]);
    }

    public function message(Request $request)
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        $form_params = [
            'question_id'  => $request->question_id,
            'assign'       => $request->assign,
            'prescription' => $request->prescription,
            'reasoning'    => $request->reasoning,
        ];

        if (isset($request->specialist_id)) {
            $form_params['specialist_id'] = $request->specialist_id;
            $message_uri = '/send_record/specialist';
        } else {
            $message_uri = '/send_record/user';
        }

        try {
            $req = new GuzzleHttpRequest('POST', $message_uri);

            $response = $client->send($req, [
                'headers'     => session('token_auth'),
                'form_params' => $form_params,
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        if ($response->getStatusCode() == 401) {
            return redirect()->route('logout');
        } elseif ($response->getStatusCode() == 200) {
            return redirect()->route('doctors.question', $request->question_id)->with('alert', [
                'class'   => 'alert-success',
                'icon'    => 'fa fa-check',
                'message' => 'Gửi thành công.',
            ]);
        } else {
            return redirect()->route('doctors.question', $request->question_id)->with('alert', [
                'class'   => 'alert-danger',
                'icon'    => 'fa fa-ban',
                'message' => 'Gửi thất bại.',
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
