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
        Schema::table('complaints', function (Blueprint $table) {
             $table->decimal('amount', 10, 2)->default(0);
        $table->boolean('is_paid')->default(false);
        $table->string('payment_order_id')->nullable();
        $table->string('payment_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['amount', 'is_paid', 'payment_order_id', 'payment_token']);

        });
    }
};
