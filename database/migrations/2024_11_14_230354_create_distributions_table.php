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
        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_item_id')->constrained('shipment_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('quantity');
            $table->integer('damaged_quantity')->default(0);
            $table->enum('status',['pending', 'verified'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributions');
    }
};
