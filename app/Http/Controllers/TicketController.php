<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index() {
    
        return response()->json(Ticket::all()); // add the statuses 
    }

    public function show(string $id) {
       
        $ticket = Ticket::findOrFail($id);
       
       return response()->json($ticket);
   }
}
