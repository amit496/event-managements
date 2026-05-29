<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SettingSeeder::class,
            EventCategorySeeder::class,
            AvenueSeeder::class,
            EventSeeder::class,
            ClientSeeder::class,
            ServiceSeeder::class,
            VendorSeeder::class,
            BookingSeeder::class,
            QuotationSeeder::class,
            TaskSeeder::class,
            EventPaymentSeeder::class,
        ]);
    }
}
