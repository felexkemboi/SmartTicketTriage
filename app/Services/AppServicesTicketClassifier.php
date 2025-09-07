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
                'explanation'  => 'Dummy explanation (OpenAI disabled)',
                'confidence'   => fake()->randomFloat(2, 0, 1),
            ];
        }

        try {
            $prompt = <<<EOT 
            You are a ticket classification system.
                Return ONLY valid JSON with keys: category, explanation, confidence (0–1).
                Categories: Technical, Payments, Inquiries, Feedback, Appointment.
                Ticket:
                Subject: {$ticket->subject}
                Body: {$ticket->body}
            EOT;

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                ],
                'temperature' => 0.2,
            ]);

            $raw = $response->choices[0]->message->content ?? '{}';

            $parsed = json_decode($raw, true);

            return [
                'category'     => $parsed['category'] ?? 'Inquiries',
                'explanation'  => $parsed['explanation'] ?? 'No explanation',
                'confidence'   => (float) ($parsed['confidence'] ?? 0.5),
            ];
        } catch (\Throwable $e) {
            Log::error("Ticket classification failed", ['error' => $e->getMessage()]);

            return [
                'category'     => 'Inquiries',
                'explanation'  => 'Fallback classification after error',
                'confidence'   => 0.1,
            ];
        }
    }
}
