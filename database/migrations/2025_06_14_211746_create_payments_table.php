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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'complaint' or 'document'
           $table->unsignedBigInteger('related_id'); // complaint_id or document_id
           $table->string('paymob_order_id')->nullable();
           $table->string('paymob_payment_token')->nullable();
           $table->decimal('amount', 10, 2);
           $table->string('status')->default('pending'); 
            $table->timestamps();

            $table->index(['type', 'related_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
