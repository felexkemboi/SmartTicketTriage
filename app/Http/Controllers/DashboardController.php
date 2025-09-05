<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the Dashboard',
            'stats' => [
                'tickets_open' => 5,
                'tickets_pending' => 3,
                'tickets_closed' => 10,
            ]
        ]);
    }
}