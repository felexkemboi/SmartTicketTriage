<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index() {
    
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'status'  => 'success',
            'message' => 'Ticket dispatched successfully',
            'tickets'  => $tickets,
        ], 200);
    }

    public function show(string $id) {
       
        $ticket = Ticket::findOrFail($id);
       
       return response()->json($ticket);
   }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'    => 'required|string|max:255',
            'body'       => 'required|string',
            'status'     => 'required|in:open,pending,closed',
            'confidence' => 'nullable|numeric|min:0|max:1',
            'category'   => 'required|in:Technical,Payments,Inquiries,Feedback,Appointment',
        ]);

        $ticket = Ticket::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Ticket created successfully',
            'ticket'  => $ticket,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'status'     => 'required|in:open,pending,closed',
            'category'   => 'required|in:Technical,Payments,Inquiries,Feedback,Appointment',
            'body'     => 'nullable|string',
        ]);

        $ticket->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Ticket updated successfully',
            'ticket'  => $ticket,
        ], 200);
    }

    public function classify(string $id) {
       
        $ticket = Ticket::findOrFail($id); 
       
        return response()->json([
            'status'  => 'success',
            'message' => 'Ticket dispatched successfully',
            'ticket'  => $ticket,
        ], 200);
   }
}
