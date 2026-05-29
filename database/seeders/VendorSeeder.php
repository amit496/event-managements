<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            ['name' => 'Prime Catering Co', 'service_type' => 'Catering', 'service_names' => ['Catering'], 'contact_person' => 'Nina Scott', 'phone' => '+15552000001', 'email' => 'prime-catering@vendor.demo', 'address' => '48 Food Park, Seattle', 'rate_card' => 3500, 'status' => true, 'notes' => 'Veg + non-veg buffet specialist.'],
            ['name' => 'Aurora Decor Studio', 'service_type' => 'Decoration', 'service_names' => ['Decoration'], 'contact_person' => 'Rohan Mehta', 'phone' => '+15552000002', 'email' => 'aurora-decor@vendor.demo', 'address' => '93 Design Lane, New York', 'rate_card' => 2800, 'status' => true, 'notes' => 'Floral and stage decoration.'],
            ['name' => 'Echo Sound & Light', 'service_type' => 'Audio/Lighting', 'service_names' => ['Sound/Lighting'], 'contact_person' => 'Mason Lee', 'phone' => '+15552000003', 'email' => 'echo-sl@vendor.demo', 'address' => '17 Amp Street, Chicago', 'rate_card' => 4200, 'status' => true, 'notes' => 'Concert and corporate audio setups.'],
            ['name' => 'FrameStory Films', 'service_type' => 'Photography', 'service_names' => ['Photography/Video'], 'contact_person' => 'Sophia King', 'phone' => '+15552000004', 'email' => 'framestory@vendor.demo', 'address' => '210 Lens Ave, Austin', 'rate_card' => 2500, 'status' => true, 'notes' => 'Photo + cinematic video packages.'],
            ['name' => 'Swift Security Crew', 'service_type' => 'Security', 'service_names' => ['Security'], 'contact_person' => 'Daniel Cruz', 'phone' => '+15552000005', 'email' => 'swift-security@vendor.demo', 'address' => '11 Guard Road, Dallas', 'rate_card' => 1800, 'status' => true, 'notes' => 'Event crowd and entry management.'],
            ['name' => 'Transit Move Services', 'service_type' => 'Transportation', 'service_names' => ['Transportation'], 'contact_person' => 'Ava Reed', 'phone' => '+15552000006', 'email' => 'transit-move@vendor.demo', 'address' => '66 Route Blvd, Boston', 'rate_card' => 2200, 'status' => true, 'notes' => 'Guest and material transport logistics.'],
            ['name' => 'Event Prime Hub', 'service_type' => 'Integrated', 'service_names' => ['Catering', 'Decoration', 'Sound/Lighting'], 'contact_person' => 'Oliver Grant', 'phone' => '+15552000007', 'email' => 'event-prime@vendor.demo', 'address' => '12 Central Plaza, San Francisco', 'rate_card' => 5600, 'status' => true, 'notes' => 'Handles bundled event operations.'],
        ];

        $serviceIdsByName = Service::query()->pluck('id', 'name');

        foreach ($vendors as $data) {
            $serviceNames = $data['service_names'] ?? [];
            unset($data['service_names']);

            $vendor = Vendor::query()->updateOrCreate(
                ['email' => $data['email']],
                $data
            );

            $syncIds = collect($serviceNames)
                ->map(fn (string $name) => $serviceIdsByName->get($name))
                ->filter()
                ->values()
                ->all();

            $vendor->services()->sync($syncIds);
        }
    }
}
