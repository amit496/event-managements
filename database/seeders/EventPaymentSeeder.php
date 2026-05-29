<?php

namespace Database\Seeders;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Event;
use App\Models\EventPayment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $financeUser = User::query()->where('email', 'finance@event.local')->first()
            ?? User::query()->where('email', 'admin@event.local')->first()
            ?? User::query()->first();

        $events = Event::query()->orderBy('id')->get();
        if ($events->isEmpty()) {
            return;
        }

        foreach ($events as $event) {
            $expectedAmount = $this->resolveExpectedAmount($event);

            if ($expectedAmount <= 0) {
                continue;
            }

            $scenario = $event->id % 3;

            if ($scenario === 0) {
                $this->upsertPayment(
                    eventId: $event->id,
                    reference: $this->reference($event->id, 1),
                    payload: [
                        'user_id' => $financeUser?->id,
                        'amount' => $expectedAmount,
                        'currency' => 'USD',
                        'payment_method' => PaymentMethod::BankTransfer->value,
                        'payment_status' => PaymentStatus::Paid->value,
                        'bank_name' => 'First Global Bank',
                        'bank_account_name' => $event->title.' Client',
                        'bank_account_number' => 'ACC'.str_pad((string) $event->id, 8, '0', STR_PAD_LEFT),
                        'bank_ifsc' => 'FGBK0001234',
                        'cheque_number' => null,
                        'cheque_date' => null,
                        'paid_at' => now()->subDays(max(1, $event->id % 9)),
                        'notes' => 'Full payment received through bank transfer.',
                    ]
                );
            } elseif ($scenario === 1) {
                $receivedAmount = round($expectedAmount * 0.55, 2);
                $dueAmount = max(round($expectedAmount - $receivedAmount, 2), 0);

                $this->upsertPayment(
                    eventId: $event->id,
                    reference: $this->reference($event->id, 1),
                    payload: [
                        'user_id' => $financeUser?->id,
                        'amount' => $receivedAmount,
                        'currency' => 'USD',
                        'payment_method' => PaymentMethod::Online->value,
                        'payment_status' => PaymentStatus::Partial->value,
                        'bank_name' => null,
                        'bank_account_name' => null,
                        'bank_account_number' => null,
                        'bank_ifsc' => null,
                        'cheque_number' => null,
                        'cheque_date' => null,
                        'paid_at' => now()->subDays(max(1, $event->id % 7)),
                        'notes' => 'Advance received online. Remaining amount pending.',
                    ]
                );

                if ($dueAmount > 0) {
                    $this->upsertPayment(
                        eventId: $event->id,
                        reference: $this->reference($event->id, 2),
                        payload: [
                            'user_id' => $financeUser?->id,
                            'amount' => $dueAmount,
                            'currency' => 'USD',
                            'payment_method' => PaymentMethod::Cheque->value,
                            'payment_status' => PaymentStatus::Pending->value,
                            'bank_name' => 'City Trust Bank',
                            'bank_account_name' => $event->title.' Client',
                            'bank_account_number' => null,
                            'bank_ifsc' => null,
                            'cheque_number' => 'CHQ'.str_pad((string) $event->id, 6, '0', STR_PAD_LEFT),
                            'cheque_date' => now()->addDays(5 + ($event->id % 4))->toDateString(),
                            'paid_at' => null,
                            'notes' => 'Cheque submitted but not cleared yet.',
                        ]
                    );
                }
            } else {
                $this->upsertPayment(
                    eventId: $event->id,
                    reference: $this->reference($event->id, 1),
                    payload: [
                        'user_id' => $financeUser?->id,
                        'amount' => $expectedAmount,
                        'currency' => 'USD',
                        'payment_method' => PaymentMethod::Cheque->value,
                        'payment_status' => PaymentStatus::Pending->value,
                        'bank_name' => 'Metro Cooperative Bank',
                        'bank_account_name' => $event->title.' Client',
                        'bank_account_number' => null,
                        'bank_ifsc' => null,
                        'cheque_number' => 'CHQ'.str_pad((string) ($event->id * 3), 6, '0', STR_PAD_LEFT),
                        'cheque_date' => now()->addDays(7 + ($event->id % 5))->toDateString(),
                        'paid_at' => null,
                        'notes' => 'Payment commitment received. Awaiting cheque clearance.',
                    ]
                );
            }
        }
    }

    private function resolveExpectedAmount(Event $event): float
    {
        $currentPayable = (float) ($event->client_payable_amount ?? 0);
        if ($currentPayable > 0) {
            return $currentPayable;
        }

        if (! $event->payment_required) {
            return 0;
        }

        $derived = max(round(((float) $event->price) * 25, 2), 1000);
        $event->client_payable_amount = $derived;
        $event->save();

        return $derived;
    }

    private function upsertPayment(int $eventId, string $reference, array $payload): void
    {
        EventPayment::query()->updateOrCreate(
            ['event_id' => $eventId, 'transaction_ref' => $reference],
            array_merge(['event_id' => $eventId, 'transaction_ref' => $reference], $payload)
        );
    }

    private function reference(int $eventId, int $index): string
    {
        return 'EVT-'.$eventId.'-P'.$index;
    }
}
