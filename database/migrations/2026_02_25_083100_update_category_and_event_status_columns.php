<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table): void {
            $table->string('status_new', 20)->default('active')->after('description');
        });

        DB::statement("UPDATE categories SET status_new = CASE WHEN status = 1 THEN 'active' ELSE 'inactive' END");

        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn('status');
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->renameColumn('status_new', 'status');
        });

        Schema::table('events', function (Blueprint $table): void {
            $table->foreignId('avenue_id')->nullable()->after('category_id')->constrained('avenues')->nullOnDelete();
            $table->boolean('payment_required')->default(false)->after('price');
            $table->string('status_new', 20)->default('published')->after('payment_required');
        });

        DB::statement("UPDATE events SET status_new = CASE WHEN status = 1 THEN 'published' ELSE 'cancelled' END");

        Schema::table('events', function (Blueprint $table): void {
            $table->dropColumn('status');
        });

        Schema::table('events', function (Blueprint $table): void {
            $table->renameColumn('status_new', 'event_status');
            $table->string('venue', 150)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->boolean('status')->default(true)->after('price');
        });

        DB::statement("UPDATE events SET status = CASE WHEN event_status IN ('published','completed') THEN 1 ELSE 0 END");

        Schema::table('events', function (Blueprint $table): void {
            $table->dropForeign(['avenue_id']);
            $table->dropColumn(['avenue_id', 'event_status', 'payment_required']);
        });

        Schema::table('categories', function (Blueprint $table): void {
            $table->boolean('status_bool')->default(true)->after('description');
        });

        DB::statement("UPDATE categories SET status_bool = CASE WHEN status = 'active' THEN 1 ELSE 0 END");

        Schema::table('categories', function (Blueprint $table): void {
            $table->dropColumn('status');
            $table->renameColumn('status_bool', 'status');
        });
    }
};
