<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->auth();
            return $next($request);
        });
    }

    protected function auth()
    {
        if (session('headers') == null || session('headers') == []) {
            return redirect()->route('login')->send();
        }
    }
}
