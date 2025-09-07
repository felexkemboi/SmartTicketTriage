<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class TicketClassifier
{
    public function classify(Ticket $ticket): array
    {

        // I am returning some dummy content below, otherwise if well set use OpenAI as below
        if (! config('openai.classify_enabled', env('OPENAI_CLASSIFY_ENABLED', false))) {
            return [
                'category'     => fake()->randomElement(['Technical', 'Payments', 'Inquiries', 'Feedback', 'Appointment']),
                'body'  => 'This is just a test body because the openAI is disabled',
                'confidence'   => fake()->randomFloat(2, 0, 1),
            ];
        }


        // Might need to prompt something here to be used below
        // $response = OpenAI::chat()->create([
        //     'model' => 'gpt-4o-mini',
        //     'messages' => [
        //         ['role' => 'system', 'content' => $prompt],
        //     ],
        //     'temperature' => 0.2,
        // ]);
    }


    public function classifyAndSave(Ticket $ticket): Ticket
    {
        $result = $this->classify($ticket);

        $manual = $ticket->category === $result['category'];
        
        if ($manual) {
            $ticket->confidence = $result['confidence'];
            $ticket->body = $result['body'];
        } else {
            $ticket->category = $result['category'];
            $ticket->confidence = $result['confidence'];
            $ticket->body = $result['body'];
        }

        $ticket->save();

        return $ticket;
    }
}
