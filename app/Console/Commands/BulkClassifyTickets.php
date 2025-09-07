<?php

namespace App\Console\Commands;

use App\Jobs\ClassifyTicket;
use App\Models\Ticket;
use Illuminate\Console\Command;

class BulkClassifyTickets extends Command
{
    protected $signature = 'tickets:bulk-classify {--limit=10}';
    protected $description = 'Classify unclassified tickets in bulk';

    public function handle(): void
    {
        $limit = (int) $this->option('limit');

        $tickets = Ticket::whereNull('body')
            ->orWhereNull('confidence')
            ->limit($limit)
            ->get();

            \Log::Debug($tickets);

        // foreach ($tickets as $ticket) {
        //     ClassifyTicket::dispatch($ticket);
        // }

        // $this->info("Dispatched classification for {$tickets->count()} tickets.");
    }
}
