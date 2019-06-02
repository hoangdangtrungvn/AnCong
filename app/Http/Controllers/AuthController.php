<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        switch ($request->type) {
            case '1':
                $loginUri = '/coordinator_auth/sign_in';
                break;
            case '2':
                $loginUri = '/dietician_auth/sign_in';
                break;
            case '3':
                $loginUri = '/specialist_auth/sign_in';
                break;
            case '4':
                $loginUri = '/doctor_auth/sign_in';
                break;
        }

        $client = new Client(['base_uri' => config('api.base_uri')]);

        try {
            $response = $client->post($loginUri, [
                'form_params' => [
                    'email'    => $request->email,
                    'password' => $request->password,
                ],
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $this->setHeaders($response->getHeaders());

        $body = json_decode($response->getBody());
        $body->success = isset($body->success) ? true : false;

        if ($body->success && $response->getStatusCode() == 200) {
            return redirect()->route('coordinators.index')->with('alert', [
                'class'   => 'alert-success',
                'icon'    => 'fa fa-check',
                'message' => 'Đăng nhập thành công.',
            ]);
        } else {
            return back()->with('alert', [
                'class'   => 'alert-danger',
                'icon'    => 'fa fa-ban',
                'message' => 'Thông tin đăng nhập không chính xác.',
            ]);
        }
    }

    public function logout()
    {
        $client = new Client(['base_uri' => config('api.base_uri')]);

        try {
            $response = $client->delete('/coordinator_auth/sign_out', [
                'headers' => session('headers'),
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        session(['headers' => null]);

        return redirect()->route('login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
            'type'     => 'required|integer|min:1|max:4',
        ], [
            'email.required'    => 'Vui lòng nhập email.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'type.required'     => 'Vui lòng chọn loại bác sĩ',
            'type.integer'      => 'Loại bác sĩ không hợp lệ.',
            'type.min'          => 'Loại bác sĩ không hợp lệ.',
            'type.max'          => 'Loại bác sĩ không hợp lệ.',
        ]);
    }

    private function setHeaders($headers)
    {
        $data = [];

        if (isset($headers['access-token'][0])) {
            $data['access-token'] = $headers['access-token'][0];
        }

        if (isset($headers['client'][0])) {
            $data['client'] = $headers['client'][0];
        }

        if (isset($headers['expiry'][0])) {
            $data['expiry'] = $headers['expiry'][0];
        }

        if (isset($headers['uid'][0])) {
            $data['uid'] = $headers['uid'][0];
        }

        session(['headers' => $data]);
    }
}
