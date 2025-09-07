<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class TicketClassifier
{
    public function classify(Ticket $ticket): array
    {

        // If disabled, return dummy classification
        if (! config('openai.classify_enabled', env('OPENAI_CLASSIFY_ENABLED', false))) {
            return [
                'category'     => fake()->randomElement(['Technical', 'Payments', 'Inquiries', 'Feedback', 'Appointment']),
                'body'  => 'This is just a test body because the openAI is disabled',
                'confidence'   => fake()->randomFloat(2, 0, 1),
            ];
        }

        // try {

        //     // Might need to prompt something here to be used below

        //     $response = OpenAI::chat()->create([
        //         'model' => 'gpt-4o-mini',
        //         'messages' => [
        //             ['role' => 'system', 'content' => $prompt],
        //         ],
        //         'temperature' => 0.2,
        //     ]);

        //     $raw = $response->choices[0]->message->content ?? '{}';

        //     $parsed = json_decode($raw, true);

        //     return [
        //         'category'     => $parsed['category'] ?? 'Inquiries',
        //         'body'  => $parsed['explanation'] ?? 'No explanation',
        //         'confidence'   => (float) ($parsed['confidence'] ?? 0.5),
        //     ];
        // } catch (\Throwable $e) {
        //     Log::error("Ticket classification failed", ['error' => $e->getMessage()]);

        //     return [
        //         'category'     => 'Inquiries',
        //         'bod'  => 'Default body when there is no other body',
        //         'confidence'   => 0.1,
        //     ];
        // }
    }


    /**
     * Classify and persist to DB.
     * but still update body (explanation) & confidence.
     */
    public function classifyAndSave(Ticket $ticket): Ticket
    {
        $result = $this->classify($ticket);

        \Log::Debug($ticket->subject);

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
