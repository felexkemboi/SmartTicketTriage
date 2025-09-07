<?php

namespace App\Console\Commands;

use App\Jobs\ClassifyTicket;
use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\RateLimiter;

class BulkClassifyTickets extends Command
{
    protected $signature = 'tickets:bulk-classify';
    protected $description = 'Classify unclassified tickets in bulk';

    public function handle(): void
    {
        $tickets = Ticket::orderBy('created_at')->get();

        foreach ($tickets as $ticket) {

            $key = 'openai-dispatch';

            ClassifyTicket::dispatch($ticket);
            
            $this->info("Queued ticket {$ticket->id}");
        }
    }
}
