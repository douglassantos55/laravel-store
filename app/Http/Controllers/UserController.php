<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('user/dashboard', ['user' => $request->user()]);
    }

    public function order(Order $order)
    {
        return view('user/order', ['order' => $order]);
    }
}
