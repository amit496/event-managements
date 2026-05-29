<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'Aarav Sharma', 'email' => 'aarav@client.demo', 'phone' => '+15551000101', 'company_name' => 'Sharma Weddings', 'city' => 'Seattle', 'address' => '101 Pine Street, Seattle', 'notes' => 'Prefers premium decor and live music.'],
            ['name' => 'Noah Wilson', 'email' => 'noah@client.demo', 'phone' => '+15551000102', 'company_name' => 'Wilson Corporate', 'city' => 'New York', 'address' => '77 Hudson Ave, New York', 'notes' => 'Corporate conferences and annual meetups.'],
            ['name' => 'Isabella Thomas', 'email' => 'isabella@client.demo', 'phone' => '+15551000103', 'company_name' => 'Thomas Family', 'city' => 'Chicago', 'address' => '12 Lake Drive, Chicago', 'notes' => 'Family events and milestone celebrations.'],
            ['name' => 'Ethan Miller', 'email' => 'ethan@client.demo', 'phone' => '+15551000104', 'company_name' => 'Miller Ventures', 'city' => 'San Francisco', 'address' => '220 Market Road, San Francisco', 'notes' => 'Needs strict timeline and status updates.'],
            ['name' => 'Olivia Davis', 'email' => 'olivia@client.demo', 'phone' => '+15551000105', 'company_name' => 'Davis Events', 'city' => 'Austin', 'address' => '89 South Congress, Austin', 'notes' => 'Recurring seasonal event bookings.'],
            ['name' => 'Liam Brown', 'email' => 'liam@client.demo', 'phone' => '+15551000106', 'company_name' => 'Brown Tech', 'city' => 'Boston', 'address' => '14 Beacon Street, Boston', 'notes' => 'Tech launch events, prefers hybrid setup.'],
            ['name' => 'Emma Garcia', 'email' => 'emma@client.demo', 'phone' => '+15551000107', 'company_name' => 'Garcia Arts', 'city' => 'Los Angeles', 'address' => '450 Sunset Blvd, Los Angeles', 'notes' => 'Wants creative stage concepts.'],
            ['name' => 'Lucas Martinez', 'email' => 'lucas@client.demo', 'phone' => '+15551000108', 'company_name' => 'Martinez Logistics', 'city' => 'Dallas', 'address' => '201 Main Loop, Dallas', 'notes' => 'Large audience events with logistics heavy setup.'],
        ];

        foreach ($clients as $data) {
            Client::query()->updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}
