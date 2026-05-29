<?php

namespace Database\Seeders;

use App\Models\Avenue;
use Illuminate\Database\Seeder;

class AvenueSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Grand Hall', 'place' => 'Downtown', 'city' => 'New York'],
            ['name' => 'Riverfront Center', 'place' => 'Riverside', 'city' => 'Chicago'],
            ['name' => 'City Convention Hub', 'place' => 'Central City', 'city' => 'Dallas'],
            ['name' => 'Sunset Arena', 'place' => 'West End', 'city' => 'Los Angeles'],
            ['name' => 'Skyline Auditorium', 'place' => 'Business Bay', 'city' => 'San Francisco'],
            ['name' => 'Heritage Banquet', 'place' => 'Old Town', 'city' => 'Boston'],
            ['name' => 'Tech Valley Pavilion', 'place' => 'Innovation Park', 'city' => 'Austin'],
            ['name' => 'Crescent Event Center', 'place' => 'North District', 'city' => 'Seattle'],
            ['name' => 'Orchid Conference Hall', 'place' => 'South Plaza', 'city' => 'Miami'],
            ['name' => 'Unity Expo Grounds', 'place' => 'Lake View', 'city' => 'Orlando'],
            ['name' => 'Civic Performance Hall', 'place' => 'Civic Center', 'city' => 'Denver'],
            ['name' => 'Maple Community Arena', 'place' => 'Maple Street', 'city' => 'Atlanta'],
            ['name' => 'Golden Square Venue', 'place' => 'Market Street', 'city' => 'Philadelphia'],
            ['name' => 'Bluewave Club Hall', 'place' => 'Harbor Point', 'city' => 'San Diego'],
            ['name' => 'Liberty Event Dome', 'place' => 'Midtown', 'city' => 'Washington'],
            ['name' => 'Parkside Multiplex', 'place' => 'Green Park', 'city' => 'Phoenix'],
            ['name' => 'Pioneer Auditorium', 'place' => 'Pioneer Road', 'city' => 'Portland'],
            ['name' => 'Starlight Convention Hall', 'place' => 'Uptown', 'city' => 'Houston'],
            ['name' => 'Summit Celebration Hall', 'place' => 'Hill District', 'city' => 'Nashville'],
            ['name' => 'Metro Cultural Center', 'place' => 'Museum Mile', 'city' => 'Detroit'],
        ];

        foreach ($rows as $row) {
            Avenue::updateOrCreate(
                ['name' => $row['name']],
                [
                    'place' => $row['place'],
                    'address' => $row['place'].', '.$row['city'],
                    'city' => $row['city'],
                    'state' => 'Sample State',
                    'country' => 'USA',
                    'status' => 'active',
                ]
            );
        }
    }
}
