<?php

namespace Database\Seeders;

use App\Models\Avenue;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::query()->orderBy('id')->take(20)->get();
        $avenues = Avenue::query()->orderBy('id')->take(20)->get();
        $admin = User::query()->where('email', 'admin@event.local')->first() ?? User::query()->first();

        if ($categories->isEmpty() || $avenues->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 20; $i++) {
            $category = $categories[($i - 1) % $categories->count()];
            $avenue = $avenues[($i - 1) % $avenues->count()];
            $startAt = now()->addDays($i * 2)->setTime(10 + ($i % 6), 0);
            $price = $i % 3 === 0 ? 0 : 25 + ($i * 5);

            Event::updateOrCreate(
                ['title' => 'Sample Event '.$i],
                [
                    'category_id' => $category->id,
                    'avenue_id' => $avenue->id,
                    'description' => 'This is sample event '.$i.' for demo and testing.',
                    'start_at' => $startAt,
                    'end_at' => (clone $startAt)->addHours(3),
                    'venue' => $avenue->name.' - '.$avenue->place,
                    'address' => $avenue->address,
                    'latitude' => $avenue->latitude,
                    'longitude' => $avenue->longitude,
                    'capacity' => 100 + ($i * 10),
                    'price' => $price,
                    'event_status' => $i <= 15 ? 'published' : 'draft',
                    'payment_required' => $price > 0,
                    'is_featured' => $i <= 6,
                    'created_by' => $admin?->id,
                ]
            );
        }
    }
}
