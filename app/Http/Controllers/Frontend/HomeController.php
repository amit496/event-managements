<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        if (! Schema::hasTable('events')) {
            return view('frontend.home', [
                'featuredEvents' => new Collection(),
                'events' => new LengthAwarePaginator([], 0, 9),
            ]);
        }

        return view('frontend.home', [
            'featuredEvents' => Event::with('category')->where('event_status', 'published')->where('is_featured', true)->latest()->take(6)->get(),
            'events' => Event::with('category')->where('event_status', 'published')->where('start_at', '>=', now())->orderBy('start_at')->paginate(9),
        ]);
    }

    public function show(Event $event)
    {
        abort_unless($event->event_status->value === 'published', 404);

        return view('frontend.event-detail', compact('event'));
    }
}
