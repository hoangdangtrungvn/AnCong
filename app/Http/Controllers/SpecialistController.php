<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleHttpRequest;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        try {
            $req = new GuzzleHttpRequest('GET', '/specialist/questions');

            $response = $client->send($req, [
                'headers' => session('token_auth'),
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        if ($response->getStatusCode() != 200) {
            return redirect()->route('logout')->with('alert', [
                'class'   => 'alert-danger',
                'icon'    => 'fa fa-ban',
                'message' => 'Không thể lấy dữ liệu.',
            ]);
        }

        $data = json_decode($response->getBody());

        $specialist_questions = $data->specialist_questions;

        return view('specialist.index')->with([
            'specialist_questions' => $specialist_questions,
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
        $doctor_records = $data->doctor_records;
        $doctor_id = $data->doctor_id;

        return view('specialist.question')->with([
            'user'           => $user,
            'question'       => $question,
            'images'         => $images,
            'doctor_id'      => $doctor_id,
            'doctor_records' => $doctor_records,
        ]);
    }

    public function message(Request $request)
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        $form_params = [
            'question_id'  => $request->question_id,
            'doctor_id'    => $request->doctor_id,
            'assign'       => $request->assign,
            'prescription' => $request->prescription,
            'reasoning'    => $request->reasoning,
        ];

        try {
            $req = new GuzzleHttpRequest('POST', '/send_record/doctor');

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
            return redirect()->route('specialists.question', $request->question_id)->with('alert', [
                'class'   => 'alert-success',
                'icon'    => 'fa fa-check',
                'message' => 'Gửi thành công.',
            ]);
        } else {
            return redirect()->route('specialists.question', $request->question_id)->with('alert', [
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
