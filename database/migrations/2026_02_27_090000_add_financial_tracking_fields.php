<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->decimal('client_payable_amount', 12, 2)->nullable()->after('price');
        });

        Schema::table('event_payments', function (Blueprint $table): void {
            $table->string('bank_name', 120)->nullable()->after('transaction_ref');
            $table->string('bank_account_name', 120)->nullable()->after('bank_name');
            $table->string('bank_account_number', 40)->nullable()->after('bank_account_name');
            $table->string('bank_ifsc', 30)->nullable()->after('bank_account_number');
            $table->string('cheque_number', 40)->nullable()->after('bank_ifsc');
            $table->date('cheque_date')->nullable()->after('cheque_number');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table): void {
            $table->dropColumn('client_payable_amount');
        });

        Schema::table('event_payments', function (Blueprint $table): void {
            $table->dropColumn([
                'bank_name',
                'bank_account_name',
                'bank_account_number',
                'bank_ifsc',
                'cheque_number',
                'cheque_date',
            ]);
        });
    }
};
