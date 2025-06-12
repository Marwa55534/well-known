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
        Schema::create('sub_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('whatsapp');
            $table->string('phone');
            $table->unsignedBigInteger('service_id'); 
            $table->unsignedBigInteger('governorate_id'); 
            $table->unsignedBigInteger('center_governorate_id'); 
            $table->timestamps();
            $table->foreign('governorate_id')->references('id')->on('governorates')->onDelete('cascade');
            $table->foreign('center_governorate_id')->references('id')->on('center_governorates')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['governorate_id']);
            $table->dropForeign(['center_governorate_id']);
        });
        Schema::dropIfExists('sub_services');
    }
};
