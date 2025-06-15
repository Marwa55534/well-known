<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->default(0);
            $table->bigInteger('payment_order_id')->nullable();
            $table->longText('payment_token')->nullable();
            $table->boolean('is_paid')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['amount', 'payment_order_id', 'payment_token', 'is_paid']);
        });
    }
};
