<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('user/dashboard', ['user' => $request->user()]);
    }

    public function order(Order $order)
    {
        if (!Gate::allows('view-order', $order)) {
            abort(403);
        }

        return view('user/order', ['order' => $order]);
    }
}
