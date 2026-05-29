<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avenues', function (Blueprint $table): void {
            $table->json('location_images')->nullable()->after('longitude');
            $table->json('event_room_images')->nullable()->after('location_images');
            $table->json('building_images')->nullable()->after('event_room_images');
        });
    }

    public function down(): void
    {
        Schema::table('avenues', function (Blueprint $table): void {
            $table->dropColumn(['location_images', 'event_room_images', 'building_images']);
        });
    }
};
