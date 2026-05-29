<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique()->default(DB::raw('(UUID())'));
            $table->string('name', 120);
            $table->string('service_type', 80)->nullable();
            $table->string('contact_person', 120)->nullable();
            $table->string('phone', 30)->nullable()->index();
            $table->string('email', 120)->nullable()->index();
            $table->text('address')->nullable();
            $table->decimal('rate_card', 12, 2)->nullable();
            $table->boolean('status')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
