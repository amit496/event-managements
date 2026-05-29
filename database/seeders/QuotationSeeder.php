<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Quotation;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::query()->with(['client', 'event'])->orderBy('id')->get();
        if ($bookings->isEmpty()) {
            return;
        }

        $statuses = Quotation::statusOptions();

        foreach ($bookings as $index => $booking) {
            $subtotal = (float) $booking->expected_amount;
            $tax = round($subtotal * 0.12, 2);
            $discount = round($subtotal * (0.03 + (($index % 3) * 0.01)), 2);
            $total = max(round($subtotal + $tax - $discount, 2), 0);

            Quotation::query()->updateOrCreate(
                ['quote_no' => 'QT-'.str_pad((string) $booking->id, 4, '0', STR_PAD_LEFT)],
                [
                    'booking_id' => $booking->id,
                    'event_id' => $booking->event_id,
                    'client_id' => $booking->client_id,
                    'subtotal' => $subtotal,
                    'tax_amount' => $tax,
                    'discount_amount' => $discount,
                    'total_amount' => $total,
                    'valid_until' => now()->addDays(14 + ($index % 10))->toDateString(),
                    'status' => $statuses[$index % count($statuses)],
                    'notes' => 'Auto generated quotation for booking '.$booking->booking_code,
                ]
            );
        }
    }
}
