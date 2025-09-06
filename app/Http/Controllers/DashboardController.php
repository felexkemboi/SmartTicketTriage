<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;


class DashboardController extends Controller
{
    public function index()
    {

        $categoryStats = Ticket::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        $statusStats = Ticket::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'status'  => 'success',
            'message' => 'Dashboard',
            'stats'   => [
                'by_status' => $statusStats,
                'by_category' => $categoryStats
             ]
        ], 200);
    }
}