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
        Schema::create('item_damages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_item_id')->constrained('shipment_items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('quantity');
            $table->longText('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_damages');
    }
};
