<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Event;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::query()->orderBy('id')->get();
        $events = Event::query()->orderBy('id')->get();

        if ($clients->isEmpty() || $events->isEmpty()) {
            return;
        }

        $statuses = Booking::statusOptions();

        foreach ($events->take(18) as $index => $event) {
            $client = $clients[$index % $clients->count()];
            $status = $statuses[$index % count($statuses)];
            $expectedAmount = (float) ($event->client_payable_amount ?? ($event->price * 20));

            Booking::query()->updateOrCreate(
                ['booking_code' => 'BK-'.str_pad((string) $event->id, 4, '0', STR_PAD_LEFT)],
                [
                    'event_id' => $event->id,
                    'client_id' => $client->id,
                    'expected_amount' => max($expectedAmount, 1000),
                    'status' => $status,
                    'event_date' => $event->start_at?->toDateString(),
                    'guest_count' => max((int) ($event->capacity ?? 100) - 20, 50),
                    'notes' => 'Auto generated booking for demo flow.',
                ]
            );
        }
    }
}
