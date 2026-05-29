<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Business Conference',
            'Technology Meetup',
            'Startup Pitch',
            'Workshop',
            'Webinar',
            'Networking Event',
            'Music Concert',
            'Art Exhibition',
            'Food Festival',
            'Sports Tournament',
            'Health and Wellness',
            'Charity Fundraiser',
            'Award Ceremony',
            'Product Launch',
            'Hackathon',
            'Career Fair',
            'Cultural Festival',
            'Education Seminar',
            'Community Meetup',
            'Fashion Show',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $name.' events category',
                    'status' => 'active',
                ]
            );
        }
    }
}
