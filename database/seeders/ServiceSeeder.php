<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Catering', 'description' => 'Food and beverage management for events.', 'status' => true],
            ['name' => 'Decoration', 'description' => 'Theme and venue decoration services.', 'status' => true],
            ['name' => 'Sound/Lighting', 'description' => 'Audio setup, microphones, and stage lighting.', 'status' => true],
            ['name' => 'Photography/Video', 'description' => 'Photography and videography packages.', 'status' => true],
            ['name' => 'Security', 'description' => 'Entry control and event security.', 'status' => true],
            ['name' => 'Transportation', 'description' => 'Guest and material transport logistics.', 'status' => true],
            ['name' => 'Live Band/DJ', 'description' => 'Live band, DJ and stage entertainment arrangements.', 'status' => true],
            ['name' => 'Anchor/Emcee', 'description' => 'Professional event host and audience engagement.', 'status' => true],
            ['name' => 'Makeup/Styling', 'description' => 'Bride, groom and guest styling services.', 'status' => true],
            ['name' => 'Floral Design', 'description' => 'Floral decor, bouquets and stage flower concepts.', 'status' => true],
            ['name' => 'Invitation/Printing', 'description' => 'Cards, banners, standees and print collaterals.', 'status' => true],
            ['name' => 'LED Wall/AV', 'description' => 'LED screen, projection and AV control systems.', 'status' => true],
            ['name' => 'Generator/Power Backup', 'description' => 'Power backup and electrical distribution setup.', 'status' => true],
            ['name' => 'Stage/Fabrication', 'description' => 'Stage design, fabrication and booth structures.', 'status' => true],
            ['name' => 'Housekeeping/Cleaning', 'description' => 'Pre-event and post-event cleaning operations.', 'status' => true],
            ['name' => 'Valet Parking', 'description' => 'Parking and vehicle flow management service.', 'status' => true],
            ['name' => 'Registration Desk', 'description' => 'Check-in counters, badges and attendee handling.', 'status' => true],
            ['name' => 'Gifting/Hampers', 'description' => 'Return gifts, hampers and corporate gifting.', 'status' => true],
            ['name' => 'Artist Management', 'description' => 'Celebrity, performer and artist coordination.', 'status' => true],
            ['name' => 'Wedding Planning', 'description' => 'End-to-end wedding planning and execution support.', 'status' => true],
            ['name' => 'Corporate Event Management', 'description' => 'Conferences, launches and business events handling.', 'status' => true],
            ['name' => 'Venue Management', 'description' => 'Venue coordination, layout and occupancy handling.', 'status' => true],
            ['name' => 'Logistics Coordination', 'description' => 'Material movement and on-ground logistics planning.', 'status' => true],
            ['name' => 'Fire & Safety', 'description' => 'Emergency response planning and compliance support.', 'status' => true],
            ['name' => 'Permit/Licensing', 'description' => 'Local authority permissions and event documentation.', 'status' => true],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
