<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('user/dashboard', ['user' => $request->user()]);
    }
}
