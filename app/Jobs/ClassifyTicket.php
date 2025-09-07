<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Services\TicketClassifier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClassifyTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function handle(TicketClassifier $classifier): void
    {
        $results = $classifier->classify($this->ticket);

        // Keep manual category if already set by user
        if (! $this->ticket->wasChanged('category') && empty($this->ticket->category)) {
            $this->ticket->category = $results['category'];
        }

        $this->ticket->explanation = $results['explanation'];
        $this->ticket->confidence  = $results['confidence'];
        $this->ticket->save();
    }
}
