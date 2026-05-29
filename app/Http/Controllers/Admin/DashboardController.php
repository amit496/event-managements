<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use App\Models\EventPayment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $monthBuckets = collect(range(5, 0))
            ->map(function (int $offset): Carbon {
                return now()->copy()->startOfMonth()->subMonths($offset);
            });

        $eventSeries = $monthBuckets->map(function (Carbon $month): int {
            return Event::query()
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->count();
        });

        $paymentSeries = $monthBuckets->map(function (Carbon $month): int {
            return EventPayment::query()
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->count();
        });

        $eventStatusDistribution = Event::query()
            ->selectRaw('event_status, COUNT(*) as aggregate')
            ->groupBy('event_status')
            ->pluck('aggregate', 'event_status');

        $successfulPaymentStatuses = [PaymentStatus::Paid->value, PaymentStatus::Partial->value];

        $eventPaymentTotals = EventPayment::query()
            ->selectRaw('event_id, SUM(amount) as received_total')
            ->whereIn('payment_status', $successfulPaymentStatuses)
            ->groupBy('event_id');

        $primaryBookings = Booking::query()
            ->select('bookings.*')
            ->join(DB::raw('(SELECT event_id, MIN(id) as booking_id FROM bookings WHERE event_id IS NOT NULL GROUP BY event_id) as primary_booking_map'), 'primary_booking_map.booking_id', '=', 'bookings.id');

        $clientCollectionRows = DB::query()
            ->fromSub($primaryBookings, 'pb')
            ->join('clients as c', 'c.id', '=', 'pb.client_id')
            ->leftJoinSub($eventPaymentTotals, 'ep', fn ($join) => $join->on('ep.event_id', '=', 'pb.event_id'))
            ->selectRaw('
                c.id as client_id,
                c.name as client_name,
                SUM(pb.expected_amount) as expected_total,
                SUM(COALESCE(ep.received_total, 0)) as received_total
            ')
            ->groupBy('c.id', 'c.name')
            ->orderByDesc('expected_total')
            ->limit(8)
            ->get()
            ->map(function ($row): array {
                $expected = (float) $row->expected_total;
                $received = (float) $row->received_total;
                $due = max($expected - $received, 0);
                $collectionPercent = $expected > 0 ? round(($received / $expected) * 100, 1) : 0;

                return [
                    'client_name' => $row->client_name,
                    'expected_total' => $expected,
                    'received_total' => $received,
                    'due_total' => $due,
                    'collection_percent' => $collectionPercent,
                ];
            });

        $overdueReceivables = DB::query()
            ->fromSub($primaryBookings, 'pb')
            ->join('clients as c', 'c.id', '=', 'pb.client_id')
            ->leftJoin('events as e', 'e.id', '=', 'pb.event_id')
            ->leftJoinSub($eventPaymentTotals, 'ep', fn ($join) => $join->on('ep.event_id', '=', 'pb.event_id'))
            ->selectRaw('
                pb.booking_code,
                pb.event_date,
                c.name as client_name,
                e.title as event_title,
                pb.expected_amount,
                COALESCE(ep.received_total, 0) as received_total
            ')
            ->whereNotNull('pb.event_date')
            ->whereDate('pb.event_date', '<', now()->toDateString())
            ->whereRaw('pb.expected_amount > COALESCE(ep.received_total, 0)')
            ->orderBy('pb.event_date')
            ->limit(10)
            ->get()
            ->map(function ($row): array {
                $expected = (float) $row->expected_amount;
                $received = (float) $row->received_total;

                return [
                    'booking_code' => $row->booking_code,
                    'client_name' => $row->client_name,
                    'event_title' => $row->event_title ?: 'N/A',
                    'event_date' => $row->event_date,
                    'due_total' => max($expected - $received, 0),
                ];
            });

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalEvents' => Event::count(),
            'upcomingEvents' => Event::query()->where('start_at', '>=', now())->count(),
            'featuredEvents' => Event::query()->where('is_featured', true)->count(),
            'chartLabels' => $monthBuckets->map(fn (Carbon $month): string => $month->format('M Y'))->values(),
            'eventSeries' => $eventSeries->values(),
            'paymentSeries' => $paymentSeries->values(),
            'statusLabels' => $eventStatusDistribution->keys()->map(fn (string $status): string => ucfirst($status))->values(),
            'statusSeries' => $eventStatusDistribution->values(),
            'clientCollections' => $clientCollectionRows,
            'overdueReceivables' => $overdueReceivables,
        ]);
    }
}
